<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Entri_Servis;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

use App\Models\Pemasukan;

class EntriServisController extends Controller
{

    public function show()
    {
        $data = Entri_Servis::with('pemasukan')->get()->map(function ($entri) {
            return [
                'id' => $entri->id,
                'plat_no' => $entri->plat_no,
                'nama_pelanggan' => $entri->nama_pelanggan,
                'status' => $entri->status,
                'nomor_whatsapp' => $entri->nomor_whatsapp,
                'keterangan' => $entri->keterangan,
                'prediksi' => $entri->prediksi,
                'harga' => $entri->harga,
                'tanggal_selesai' => $entri->tanggal_selesai,
                'sudah_dibayar' => $entri->pemasukan !== null,
                'created_at' => $entri->created_at,
                'updated_at' => $entri->updated_at,
            ];
        });

        return response()->json([
            'message' => 'Berhasil mengambil semua data entri servis',
            'data' => $data
        ]);
    }

    public function showById($id)
    {
        $data = Entri_Servis::with('pemasukan')->find($id);

        if (!$data) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Tambahkan properti secara manual
        $data->sudah_bayar = $data->pemasukan !== null;

        return response()->json([
            'message' => 'Data berhasil diambil',
            'data' => $data
        ], 200);
    }

    public function showByPlatNo(Request $request)
    {
        $plat_no = $request->input('plat_no');
        $data = Entri_Servis::where('plat_no', $plat_no)
            ->orderBy('created_at', 'desc')
            ->get();

        if ($data->isEmpty()) {
            return response()->json([
                'message' => 'Data yang Anda Cari Tidak Ditemukan'
            ], 404);
        }

        return response()->json([
            'message' => 'Data entri servis ditemukan',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        // Debug: Lihat apakah request masuk
        Log::info($request->all());

        // Validasi input
        $request->validate([
            'plat_no' => 'required|string|max:255',
            'nama_pelanggan' => 'required|string|max:255',
            'status' => 'required|in:Dalam antrian,Sedang diperbaiki,Selesai',
            'nomor_whatsapp' => 'required|string',
            'keterangan' => 'nullable|string',
            'prediksi' => 'nullable|string',
            'harga' => 'required|integer|min:0',
            'tanggal_selesai' => 'nullable|date',
        ]);

        // Simpan data ke database
        $entriServis = Entri_Servis::create($request->all());

        return response()->json([
            'message' => 'Entri servis berhasil ditambahkan',
            'data' => $entriServis
        ], 201);
    }

    public function update(Request $request, $id)
    {
        // Debug: Lihat apakah request masuk
        Log::info($request->all());

        // Temukan data berdasarkan ID
        $entriServis = Entri_Servis::find($id);

        // Jika tidak ditemukan, kirim response error
        if (!$entriServis) {
            return response()->json([
                'message' => 'Data entri servis tidak ditemukan'
            ], 404);
        }

        // Validasi input
        $request->validate([
            'plat_no' => 'sometimes|string|max:255',
            'nama_pelanggan' => 'sometimes|string|max:255',
            'status' => 'sometimes|in:Dalam antrian,Sedang diperbaiki,Selesai',
            'nomor_whatsapp' => 'sometimes|string',
            'keterangan' => 'nullable|string',
            'prediksi' => 'nullable|string',
            'harga' => 'sometimes|integer|min:0',
            'tanggal_selesai' => 'sometimes|date',
        ]);

        // Ambil semua input kecuali _method
        $data = $request->except('_method');

        // Cek jika status diubah ke "Selesai"
        if (isset($data['status']) && $data['status'] === 'Selesai') {
            $data['tanggal_selesai'] = Carbon::now(); // Atur tanggal selesai ke sekarang
        }

        // Update data
        $entriServis->update($data);

        return response()->json([
            'message' => 'Entri servis berhasil diperbarui',
            'data' => $entriServis
        ], 200);
    }

    public function delete(Request $request, $id)
    {
        // Debug log (opsional)
        Log::info("Request Delete Entri Servis ID: $id");

        // Cari entri_servis berdasarkan ID
        $entriServis = Entri_Servis::find($id);

        if (!$entriServis) {
            return response()->json([
                'message' => 'Data entri servis tidak ditemukan'
            ], 404);
        }

        // Ambil semua data pemasukan yang terkait dengan entri_servis ini
        $pemasukanList = Pemasukan::where('id_servis', $id)->get();

        // Loop dan hapus masing-masing file + record pemasukan
        foreach ($pemasukanList as $pemasukan) {
            if ($pemasukan->bukti_pemasukan) {
                $path = str_replace('/storage/', '', $pemasukan->bukti_pemasukan);
                Storage::disk('public')->delete($path);
            }

            $pemasukan->delete();
        }

        // Hapus entri_servis
        $entriServis->delete();

        return response()->json([
            'message' => 'Entri servis dan semua data pemasukan terkait berhasil dihapus'
        ], 200);
    }


}
