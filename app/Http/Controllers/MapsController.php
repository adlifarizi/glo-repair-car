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


    public function store(Request $request)
    {
        // Debug: Lihat apakah request masuk
        Log::info($request->all());

        // Validasi input
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'embed_url' => 'nullable|text',
        ]);

        // Simpan data ke database
        $maps = Maps::create($request->all());

        return response()->json([
            'message' => 'Maps berhasil ditambahkan',
            'data' => $maps
        ], 201);
    }


    public function update(Request $request, $id)
    {
        // Debug: Lihat apakah request masuk
        Log::info($request->all());

        // Temukan data berdasarkan ID
        $maps = Maps::find($id);

        // Jika tidak ditemukan, kirim response error
        if (!$maps) {
            return response()->json([
                'message' => 'Data kontak tidak ditemukan'
            ], 404);
        }

        // Validasi input
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'embed_url' => 'nullable|text',
        ]);

        // Update data dengan input yang diberikan
        $maps->update($request->except('_method'));

        return response()->json([
            'message' => 'Maps berhasil diperbarui',
            'data' => $maps
        ], 200);
    }

    public function delete(Request $request, $id)
    {
        // Debug: Lihat apakah request masuk
        Log::info($request->all());

        // Temukan data berdasarkan ID
        $maps = Maps::find($id);

        // Jika tidak ditemukan, kirim response error
        if (!$maps) {
            return response()->json([
                'message' => 'Data maps tidak ditemukan'
            ], 404);
        }

        // Hapus data
        $maps->delete();

        // Buat entri baru tanpa perlu menentukan nilai default secara manual
        $defaultMaps = Maps::create([]);

        return response()->json([
            'message' => 'Maps berhasil dihapus dan data default ditambahkan',
            'data' => $defaultMaps
        ], 200);
    }
}
