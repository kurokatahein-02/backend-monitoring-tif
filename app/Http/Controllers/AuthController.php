<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Fungsi untuk Login
    public function login(Request $request)
    {
        // 1. Validasi input: pastikan email dan password diisi
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // 2. Cek apakah email dan password cocok dengan yang ada di database
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Email atau password salah kak!'
            ], 401); // 401 artinya Unauthorized (tidak diizinkan)
        }

        // 3. Jika cocok, ambil data usernya
        $user = User::where('email', $request->email)->firstOrFail();
        
        // 4. Buatkan Token Sanctum untuk user tersebut
        $token = $user->createToken('auth_token')->plainTextToken;

        // 5. Kembalikan tokennya dalam format JSON
        return response()->json([
            'message' => 'Berhasil login!',
            'access_token' => $token,
            'token_type' => 'Bearer'
        ]);
    }

    // Fungsi untuk Logout
    public function logout(Request $request)
    {
        // Hapus token yang sedang dipakai saat ini
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Berhasil logout dan token telah dihapus'
        ]);
    }
}