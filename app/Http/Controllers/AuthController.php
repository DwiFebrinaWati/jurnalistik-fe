<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Mail\ResetPasswordMail;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $val = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $val['name'],
            'email' => $val['email'],
            'password' => Hash::make($val['password']),
            'role_id' => 3, // Default role is Author
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $user->tokens()->delete();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => [
            'name' => $user->name,
            'role_id' => $user->role_id
        ]
    ]);
}

    public function redirectToGoogle()
    {
        return response()->json([
        'url' => Socialite::driver('google')->stateless()->redirect()->getTargetUrl()
    ]);
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();
            $user = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'password' => Hash::make(Str::random(24)),
                    'role_id' => 3,
                ]
            );

            $token = $user->createToken('google_auth_token')->plainTextToken;

            return response()->json([
            'message' => 'Login Google Berhasil',
            'user' => new UserResource($user), 
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal login'], 500);
        }
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ], [
            'email.exists' => 'Email tidak terdaftar di sistem kami.'
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $request->email],
            [
                'token' => $token,
                'created_at' => now()
            ]
        );

        $frontendUrl = config('app.frontend_url') . "/reset-password?token=" . $token . "&email=" . $request->email;

        try {
            Mail::to($request->email)->send(new ResetPasswordMail($frontendUrl));

            return response()->json([
                'message' => 'Link reset password telah dikirim ke email Anda!'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal mengirim email. Silakan coba lagi nanti.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $resetRequest = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->where('token', $request->token)
            ->first();

        if (!$resetRequest || Carbon::parse($resetRequest->created_at)->addMinutes(60)->isPast()) {
            return response()->json(['message' => 'Token tidak valid atau sudah kadaluwarsa.'], 422);
        }

        $user = User::where('email', $request->email)->first();
        $user->update([
            'password' => bcrypt($request->password)
        ]);

        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json(['message' => 'Password berhasil diubah. Silakan login kembali.']);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
