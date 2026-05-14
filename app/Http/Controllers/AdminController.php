<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class AdminController extends Controller
{
    public function index()
    {
        try {
            $users = User::with('role')->get();
            $data = $users->map(function ($user) {
                return [
                    'id'    => $user->user_id,
                    'name'  => $user->name,
                    'email' => $user->email,
                    'role'  => $user->role ? $user->role->nama_role : 'No Role',
                    'role_id' => $user->role_id
                ];
            });

            return response()->json([
                'success' => true,
                'data'    => $data
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data user',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

public function updateRole(Request $request, $userId)
{
    $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:users,email,'.$userId. ',user_id',
        'role_id' => 'required|integer|exists:roles,role_id',
    ]);

    try {
        $user = User::findOrFail($userId);
        $user->update($request->only(['name', 'email', 'role_id']));

        return response()->json([
            'success' => true,
            'message' => "Data {$user->name} berhasil diupdate."
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Terjadi kesalahan saat mengupdate data.',
            'error' => $e->getMessage()
        ], 500);
    }
}

    public function destroy($userId)
    {
        try {
            $user = User::findOrFail($userId);
            if ($user->id === auth()->id()) {
                return response()->json(['message' => 'Tidak bisa menghapus akun sendiri'], 403);
            }

            $user->delete();

            return response()->json([
                'success' => true,
                'message' => 'User berhasil dihapus'
            ], 200);

        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus user',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
