<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Pengeluaran;
use Illuminate\Support\Str;

class PengeluaranController extends Controller
{
    // Menampilkan seluruh data pengeluaran
    public function show()
    {
        $pengeluaran = Pengeluaran::all(); // Mengambil semua data

        if ($pengeluaran->isEmpty()) {  // Mengecek apakah data kosong
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data berhasil diambil',
            'data' => $pengeluaran
        ], 200);
    }

    // Menampilkan detail pengeluaran berdasarkan ID
    public function showById($id)
    {
        $pengeluaran = Pengeluaran::find($id);

        if (!$pengeluaran) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data berhasil diambil',
            'data' => $pengeluaran
        ], 200);
    }


    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nominal' => 'required|integer',
            'keterangan' => 'nullable|string',
            'tanggal_pengeluaran' => 'required|date',
            'bukti_pengeluaran' => 'required|file|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        try {
            if ($request->hasFile('bukti_pengeluaran')) {
                $imagePath = $request->file('bukti_pengeluaran')->store('images/bukti_pengeluaran', 'public');
                $validatedData['bukti_pengeluaran'] = Storage::url($imagePath);
            }

            $pengeluaran = Pengeluaran::create([
                'nominal' => $validatedData['nominal'],
                'keterangan' => $validatedData['keterangan'] ?? null,
                'tanggal_pengeluaran' => $validatedData['tanggal_pengeluaran'],
                'bukti_pengeluaran' => $validatedData['bukti_pengeluaran'],
            ]);

            return response()->json([
                'message' => 'Pengeluaran berhasil disimpan',
                'data' => $pengeluaran
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
            'nominal' => 'nullable|integer',
            'keterangan' => 'nullable|string',
            'tanggal_pengeluaran' => 'nullable|date',
            'bukti_pengeluaran' => 'nullable|file|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);
    
        try {
            $pengeluaran = Pengeluaran::find($id);
    
            if (!$pengeluaran) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }
    
            // Tangani file jika ada
            if ($request->hasFile('bukti_pengeluaran')) {
                if ($pengeluaran->bukti_pengeluaran) {
                    $oldPath = str_replace('/storage/', '', $pengeluaran->bukti_pengeluaran);
                    Storage::disk('public')->delete($oldPath);
                }
    
                $imagePath = $request->file('bukti_pengeluaran')->store('images/bukti_pengeluaran', 'public');
                $validatedData['bukti_pengeluaran'] = Storage::url($imagePath);
            }
    
            // Langsung update
            $pengeluaran->update($validatedData);
    
            return response()->json([
                'message' => 'Data pengeluaran berhasil diperbarui',
                'data' => $pengeluaran
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
            $pengeluaran = Pengeluaran::find($id);

            if (!$pengeluaran) {
                return response()->json([
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            // Hapus file bukti pengeluaran jika ada
            if ($pengeluaran->bukti_pengeluaran) {
                $path = str_replace('/storage/', '', $pengeluaran->bukti_pengeluaran);
                Storage::disk('public')->delete($path);
            }

            $pengeluaran->delete();

            return response()->json([
                'message' => 'Data pengeluaran berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Terjadi kesalahan saat menghapus data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
}
