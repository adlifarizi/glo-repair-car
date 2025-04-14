<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class KontakController extends Controller
{
    public function show()
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


    public function store(Request $request)
    {
        // Debug: Lihat apakah request masuk
        Log::info($request->all());

        // Validasi input
        $request->validate([
            'email' => 'nullable|email',
            'nomor_telepon' => 'required|string',
            'nomor_whatsapp' => 'nullable|string',
            'instagram' => 'nullable|string',
        ]);

        // Simpan data ke database
        $kontak = Kontak::create($request->all());

        return response()->json([
            'message' => 'Kontak berhasil ditambahkan',
            'data' => $kontak
        ], 201);
    }


    public function update(Request $request, $id)
    {
        // Debug: Lihat apakah request masuk
        Log::info($request->all());

        // Temukan data berdasarkan ID
        $kontak = Kontak::find($id);

        // Jika tidak ditemukan, kirim response error
        if (!$kontak) {
            return response()->json([
                'message' => 'Data kontak tidak ditemukan'
            ], 404);
        }

        // Validasi input
        $request->validate([
            'email' => 'nullable|string',
            'nomor_telepon' => 'required|string',
            'nomor_whatsapp' => 'nullable|string',
            'instagram' => 'nullable|string',
        ]);

        // Update data dengan input yang diberikan
        $kontak->update($request->except('_method'));

        return response()->json([
            'message' => 'Kontak berhasil diperbarui',
            'data' => $kontak
        ], 200);
    }

    public function delete(Request $request, $id)
    {
        // Debug: Lihat apakah request masuk
        Log::info($request->all());

        // Temukan data berdasarkan ID
        $kontak = Kontak::find($id);

        // Jika tidak ditemukan, kirim response error
        if (!$kontak) {
            return response()->json([
                'message' => 'Data Kontak tidak ditemukan'
            ], 404);
        }

        // Hapus data
        $kontak->delete();

        // Buat entri baru tanpa perlu menentukan nilai default secara manual
        $defaultKontak = Kontak::create([]);

        return response()->json([
            'message' => 'Kontak berhasil dihapus dan data default ditambahkan',
            'data' => $defaultKontak
        ], 200);
    }
}
