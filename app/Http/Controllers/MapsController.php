<?php

namespace App\Http\Controllers;

use App\Models\Maps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MapsController extends Controller
{

    public function show()
    {
        $maps = Maps::first();

        if (!$maps) {
            return response()->json([
                'message' => 'Data maps tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data maps berhasil diambil',
            'data' => $maps
        ], 200);
    }

    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'embed_url' => 'nullable|string',
        ]);

        // Cek apakah data maps sudah ada
        $maps = Maps::first();

        if ($maps) {
            // Kalau sudah ada, update
            $maps->update([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'embed_url' => $request->embed_url
            ]);

            $message = 'Maps berhasil diperbarui';
            $statusCode = 200;
        } else {
            // Kalau belum ada, buat baru
            $maps = Maps::create([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'embed_url' => $request->embed_url
            ]);

            $message = 'Maps berhasil dibuat';
            $statusCode = 201;
        }

        return response()->json([
            'message' => $message,
            'data' => $maps
        ], $statusCode);
    }

}
