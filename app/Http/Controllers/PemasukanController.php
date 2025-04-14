<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Pemasukan;
use Illuminate\Support\Str;

class PemasukanController extends Controller
{
    // Menampilkan seluruh data pemasukan
    public function show()
    {
        $pemasukan = Pemasukan::all(); // Mengambil semua data

        if ($pemasukan->isEmpty()) {  // Mengecek apakah data kosong
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json($pemasukan);
    }

    // Menampilkan detail pemasukan berdasarkan ID
    public function showById($id)
    {
        $pemasukan = Pemasukan::find($id);

        if (!$pemasukan) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json($pemasukan);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'id_servis' => 'required|exists:entri_servis,id',
            'nominal' => 'required|integer',
            'keterangan' => 'nullable|string',
            'tanggal_pemasukan' => 'required|date',
            'bukti_pemasukan' => 'required|file|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        try {
            if ($request->hasFile('bukti_pemasukan')) {
                $imagePath = $request->file('bukti_pemasukan')->store('images/bukti_pemasukan', 'public');
                $validatedData['bukti_pemasukan'] = Storage::url($imagePath);
            }

            $pemasukan = Pemasukan::create([
                'id_servis' => $validatedData['id_servis'],
                'nominal' => $validatedData['nominal'],
                'keterangan' => $validatedData['keterangan'] ?? null,
                'tanggal_pemasukan' => $validatedData['tanggal_pemasukan'],
                'bukti_pemasukan' => $validatedData['bukti_pemasukan'],
            ]);

            return response()->json([
                'message' => 'Pemasukan berhasil disimpan',
                'data' => $pemasukan
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menyimpan data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_servis' => 'nullable|exists:entri_servis,id',
            'nominal' => 'nullable|integer',
            'keterangan' => 'nullable|string',
            'tanggal_pemasukan' => 'nullable|date',
            'bukti_pemasukan' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        try {
            $pemasukan = Pemasukan::find($id);

            if (!$pemasukan) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Tangani file jika ada
            if ($request->hasFile('bukti_pemasukan')) {
                if ($pemasukan->bukti_pemasukan) {
                    $oldPath = str_replace('/storage/', '', $pemasukan->bukti_pemasukan);
                    Storage::disk('public')->delete($oldPath);
                }

                $imagePath = $request->file('bukti_pemasukan')->store('images/bukti_pemasukan', 'public');
                $validatedData['bukti_pemasukan'] = Storage::url($imagePath);
            }

            // Langsung update
            $pemasukan->update($validatedData);

            return response()->json([
                'message' => 'Data pemasukan berhasil diperbarui',
                'data' => $pemasukan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat memperbarui data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $pemasukan = Pemasukan::find($id);

            if (!$pemasukan) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Hapus file bukti pemasukan jika ada
            if ($pemasukan->bukti_pemasukan) {
                $path = str_replace('/storage/', '', $pemasukan->bukti_pemasukan);
                Storage::disk('public')->delete($path);
            }

            $pemasukan->delete();

            return response()->json([
                'message' => 'Data pemasukan berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
