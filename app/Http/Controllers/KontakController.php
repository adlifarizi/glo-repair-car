<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KontakController extends Controller
{
    public function show(): JsonResponse
    {
        $kontak = Kontak::first();

        if (!$kontak) {
            return response()->json([
                'message' => 'Data kontak tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data kontak berhasil diambil',
            'data' => $kontak
        ], 200);
    }

    public function update(Request $request): JsonResponse
    {
        // Validasi input
        $request->validate([
            'email' => 'nullable|email',
            'nomor_telepon' => 'required|string',
            'nomor_whatsapp' => 'nullable|string',
            'instagram' => 'nullable|string',
        ]);

        // Cek apakah data kontak sudah ada
        $kontak = Kontak::first();

        if ($kontak) {
            // Kalau sudah ada, update
            $kontak->update([
                'email' => $request->email,
                'nomor_telepon' => $request->nomor_telepon,
                'nomor_whatsapp' => $request->nomor_whatsapp,
                'instagram' => $request->instagram
            ]);

            $message = 'Kontak berhasil diperbarui';
            $statusCode = 200;
        } else {
            // Kalau belum ada, buat baru
            $kontak = Kontak::create([
                'email' => $request->email,
                'nomor_telepon' => $request->nomor_telepon,
                'nomor_whatsapp' => $request->nomor_whatsapp,
                'instagram' => $request->instagram
            ]);

            $message = 'Kontak berhasil dibuat';
            $statusCode = 201;
        }

        return response()->json([
            'message' => $message,
            'data' => $kontak
        ], $statusCode);
    }

}
