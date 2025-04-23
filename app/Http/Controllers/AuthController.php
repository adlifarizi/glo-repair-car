<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    // Registrasi Admin
    public function register(Request $request): JsonResponse
    {

        // Cek apakah environment adalah production
        if (app()->environment('production')) {
            return response()->json(['error' => 'Registrasi admin tidak diizinkan di environment production.'], 403);
        }

        // Cek apakah sudah ada admin
        if (Admin::count() > 0) {
            return response()->json(['error' => 'Akun admin sudah ada. Tidak bisa membuat lebih dari satu akun.'], 403);
        }

        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:admins',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Simpan admin dengan password yang di-hash
            $admin = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password), // Pastikan password di-hash
            ]);

            return response()->json(['message' => "Admin {$admin->name} berhasil dibuat!"], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => $e], 500);
        }
    }

    // Login Admin
    public function login(Request $request): JsonResponse
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $validator->errors()], 422);
        }

        try {
            // Cari admin berdasarkan email
            $admin = Admin::where('email', $request->email)->first();

            // Debugging: Cek apakah admin ditemukan dan memiliki ID yang valid
            if (!$admin) {
                return response()->json(['message' => 'Login gagal, Akun tidak terdaftar!'], 401);
            }

            if (!$admin->id) {
                return response()->json(['message' => 'ID admin tidak ditemukan!'], 500);
            }

            // Debugging: Cek apakah password cocok
            if (!Hash::check($request->password, $admin->password)) {
                return response()->json(['message' => 'Password salah'], 401);
            }

            // Debugging: Coba buat token
            try {
                $token = $admin->createToken('auth_token')->plainTextToken;
            } catch (\Exception $e) {
                return response()->json(['message' => 'Gagal membuat token', 'error' => $e->getMessage()], 500);
            }

            return response()->json([
                'message' => 'Login berhasil',
                'access_token' => $token,
                'token_type' => 'Bearer',
                'admin_id' => $admin->id,
                'admin_name' => $admin->name,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat login',
                'error' => $e->getMessage(), // Tambahkan detail error
            ], 500);
        }
    }

    // Logout Admin
    public function logout(Request $request): JsonResponse
    {
        try {
            // Hapus token saat ini (bukan semua token)
            $request->user()->currentAccessToken()->delete();

            return response()->json([
                'message' => 'Berhasil log out',
                'loggedOut' => true
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Gagal log out'], 500);
        }
    }

    // Cek apakah token masih valid
    public function checkToken(Request $request): JsonResponse
    {
        try {
            $authHeader = $request->header('Authorization');

            if (!$authHeader || !str_starts_with($authHeader, 'Bearer ')) {
                return response()->json(['message' => 'Token tidak ditemukan atau tidak valid'], 401);
            }

            $tokenString = substr($authHeader, 7);
            $token = PersonalAccessToken::findToken($tokenString);

            if (!$token) {
                return response()->json(['message' => 'Token tidak valid'], 401);
            }

            return response()->json([
                'message' => 'Token masih valid',
                'valid' => true,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat memeriksa token'], 500);
        }
    }
}
