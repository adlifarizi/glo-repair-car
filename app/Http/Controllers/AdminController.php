<?php

namespace App\Http\Controllers;

use App\Models\Entri_Servis;
use App\Models\Feedback;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Facades\Crypt;

class AdminController extends Controller
{
    public function getNameById(Request $request): JsonResponse
    {
        // Retrieve the encrypted user ID from the request headers
        $encryptedUserId = $request->header('user_id');

        try {
            // Decrypt the user ID
            $userId = Crypt::decryptString($encryptedUserId);
        } catch (\Exception $e) {
            // Return an error if decryption fails
            return response()->json(['error' => 'Invalid user ID'], 400);
        }

        // Fetch the user's name from the database by the decrypted ID
        $user = DB::table('users')->where('id', $userId)->first();

        // Check if the user exists
        if ($user) {
            return response()->json(['name' => $user->name]);
        }

        // Return an error if the user was not found
        return response()->json(['error' => 'User not found'], 404);
    }


    public function getAllNames(): JsonResponse
    {
        // Fetch all user names from the 'users' table
        $users = DB::table('users')->pluck('name');

        // Check if any users were found
        if ($users->isEmpty()) {
            return response()->json(['error' => 'No users found'], 404);
        }

        // Return the list of names in JSON format
        return response()->json(['names' => $users]);
    }

    public function getDashboardData()
    {
        // 1. JUMLAH servis dengan status 'Sedang diperbaiki'
        $jumlahServisDalamPerbaikan = Entri_Servis::where('status', 'Sedang diperbaiki')->count();

        // 2. JUMLAH transaksi selesai (status 'Selesai')
        $jumlahTransaksiSelesai = Entri_Servis::where('status', 'Selesai')->count();

        // 3. Rata-rata rating bengkel
        $averageRating = Feedback::avg('rating');

        // 4. Total pemasukan bulan ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $totalPemasukanBulanIni = Pemasukan::whereBetween('tanggal_pemasukan', [$startOfMonth, $endOfMonth])
            ->sum('nominal');

        // 5. Total pengeluaran bulan ini
        $totalPengeluaranBulanIni = Pengeluaran::whereBetween('tanggal_pengeluaran', [$startOfMonth, $endOfMonth])
            ->sum('nominal');

        return response()->json([
            'success' => true,
            'data' => [
                'jumlah_servis_dalam_perbaikan' => (int) $jumlahServisDalamPerbaikan,
                'jumlah_transaksi_selesai' => (int) $jumlahTransaksiSelesai,
                'rata_rata_rating' => (float) round($averageRating, 1),
                'total_pemasukan_bulan_ini' => (int) $totalPemasukanBulanIni,
                'total_pengeluaran_bulan_ini' => (int) $totalPengeluaranBulanIni,
            ],
            'message' => 'Data dashboard berhasil diambil'
        ], 200);
    }


    public function generatePDF()
    {
        // Ambil tanggal awal bulan dan tanggal sekarang
        $startDate = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endDate = Carbon::now()->format('Y-m-d');
        $bulanTahun = Carbon::now()->translatedFormat('F Y');
        $tanggalUnduh = Carbon::now()->translatedFormat('j F Y, H.i');

        // Ambil data pemasukan dan pengeluaran bulan ini
        $pemasukan = Pemasukan::whereBetween('tanggal_pemasukan', [$startDate, $endDate])->get();
        $pengeluaran = Pengeluaran::whereBetween('tanggal_pengeluaran', [$startDate, $endDate])->get();

        // Hitung total
        $totalPemasukan = $pemasukan->sum('nominal');
        $totalPengeluaran = $pengeluaran->sum('nominal');
        $labaRugi = $totalPemasukan - $totalPengeluaran;

        // Format data untuk ditampilkan
        $formattedData = [
            'bulan_tahun' => $bulanTahun,
            'tanggal_unduh' => $tanggalUnduh,
            'pemasukan' => $pemasukan,
            'pengeluaran' => $pengeluaran,
            'total_pemasukan' => $totalPemasukan,
            'total_pengeluaran' => $totalPengeluaran,
            'laba_rugi' => $labaRugi,
            'transaksi' => $this->formatTransaksi($pemasukan, $pengeluaran)
        ];

        // Generate PDF
        $pdf = PDF::loadView('laporan.keuangan', $formattedData);

        return $pdf->download('Laporan-Keuangan-' . $bulanTahun . '.pdf');
    }

    private function formatTransaksi($pemasukan, $pengeluaran)
    {
        $transaksi = [];

        // Gabungkan dan format data transaksi
        foreach ($pemasukan as $item) {
            $transaksi[] = [
                'tanggal' => Carbon::parse($item->tanggal_pemasukan)->translatedFormat('j F Y'),
                'keterangan' => $item->keterangan ?? 'Pemasukan Servis',
                'nominal' => $item->nominal,
                'jenis' => 'pemasukan'
            ];
        }

        foreach ($pengeluaran as $item) {
            $transaksi[] = [
                'tanggal' => Carbon::parse($item->tanggal_pengeluaran)->translatedFormat('j F Y'),
                'keterangan' => $item->keterangan,
                'nominal' => $item->nominal,
                'jenis' => 'pengeluaran'
            ];
        }

        // Urutkan berdasarkan tanggal
        usort($transaksi, function ($a, $b) {
            return strtotime($a['tanggal']) - strtotime($b['tanggal']);
        });

        return $transaksi;
    }
}
