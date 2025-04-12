<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('main.index');
});

Route::get('/layanan', function () {
    return view('main.layanan');
});

Route::get('/ulasan', function () {
    return view('main.ulasan');
});

Route::get('/kontak', function () {
    return view('main.kontak');
});

// Admin Route
Route::get('/login', function () {
    return view('admin.layouts.login');
});

Route::get('/dashboard', function () {
    return view('admin.index');
});

Route::get('/kelola-entri-servis', function () {
    $pelanggan = collect([
        (object) [
            'id' => 1,
            'plat_nomor' => 'F 5383 UBT',
            'nama_pelanggan' => 'Glorian Hilarius',
            'nomor_whatsapp' => '081234567890',
            'status_servis' => 'Selesai',
            'keterangan' => 'Ganti oli, cek rem',
            'harga' => 150000,
            'kunjungan_selanjutnya' => '2025-05-01',
        ],
        (object) [
            'id' => 2,
            'plat_nomor' => 'B 1234 ABC',
            'nama_pelanggan' => 'Indra Wijaya',
            'nomor_whatsapp' => '082198765432',
            'status_servis' => 'Dalam Perbaikan',
            'keterangan' => 'Servis mesin',
            'harga' => 300000,
            'kunjungan_selanjutnya' => '2025-06-10',
        ],
        (object) [
            'id' => 3,
            'plat_nomor' => 'D 5678 DEF',
            'nama_pelanggan' => 'Maria Lestari',
            'nomor_whatsapp' => '089876543210',
            'status_servis' => 'Dalam Antrian',
            'keterangan' => 'Cek AC dan kelistrikan',
            'harga' => 250000,
            'kunjungan_selanjutnya' => '2025-04-20',
        ],
    ]);

    return view('admin.manage-service-entries', compact('pelanggan'));
});

Route::get('/tambah-entri-servis', function () {
    return view('admin.form-service-entry');
});

Route::get('/ubah-entri-servis/{id}', function () {
    $entriServis = (object) [
        'id' => 3,
            'plat_nomor' => 'D 5678 DEF',
            'nama_pelanggan' => 'Maria Lestari',
            'nomor_whatsapp' => '089876543210',
            'status_servis' => 'Dalam Antrian',
            'keterangan' => 'Cek AC dan kelistrikan',
            'harga' => 250000,
            'kunjungan_selanjutnya' => '2025-04-20',
    ];
    return view('admin.form-service-entry', compact('entriServis'));
});

Route::post('/entry-store', function () {
    return view('admin.form-service-entry');
})->name('entry.store');

Route::put('/entry-update', function () {
    return view('admin.form-service-entry');
})->name('entry.update');

