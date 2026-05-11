<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;

class AdminController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna
     */
    public function index()
    {
        try {
            // Mengambil semua user beserta data rolenya
            // Pastikan di model User sudah ada relasi 'role'
            $users = User::with('role')->get();

            // Transformasi data agar frontend mudah membaca nama rolenya
            $data = $users->map(function ($user) {
                return [
                    'id'    => $user->user_id,
                    'name'  => $user->name,
                    'email' => $user->email,
                    'role'  => $user->role ? $user->role->nama_role : 'No Role', // Sesuaikan kolom nama role kamu
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

    /**
     * Update role user
     */
public function updateRole(Request $request, $userId)
{
    $request->validate([
        'name' => 'sometimes|string|max:255',
        'email' => 'sometimes|email|unique:users,email,'.$userId. ',user_id',
        'role_id' => 'required|integer|exists:roles,role_id',
    ]);

    try {
        $user = User::findOrFail($userId);

        // Melakukan update hanya pada kolom yang diizinkan
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

    /**
     * Menghapus user
     */
    public function destroy($userId)
    {
        try {
            $user = User::findOrFail($userId);

            // Opsional: Cegah admin menghapus dirinya sendiri
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
