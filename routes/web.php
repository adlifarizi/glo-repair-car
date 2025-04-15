<?php

use App\Http\Middleware\CheckSanctumToken;
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
    $latitude = -6.5891473;
    $longitude = 106.806127;
    return view('main.kontak', compact('latitude', 'longitude'));
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

Route::get('/kelola-ulasan', function () {
    $ulasan = collect([
        (object) [
            'id' => 1,
            'plat_no' => 'F 5383 UBT',
            'nama_pelanggan' => 'Glorian Hilarius',
            'rating' => 5,
            'feedback' => 'Fasilitas bagus, Montir, admin-nya dan pemiliknya juga ramah. harga terbaik',
            'show' => true,
        ],
        (object) [
            'id' => 2,
            'plat_no' => 'B 1234 ABC',
            'nama_pelanggan' => 'Indra Wijaya',
            'rating' => 4,
            'feedback' => 'Fasilitas bagus, Montir, admin-nya dan pemiliknya juga ramah. harga terbaik',
            'show' => true,
        ],
        (object) [
            'id' => 3,
            'plat_no' => 'D 5678 DEF',
            'nama_pelanggan' => 'Maria Lestari',
            'rating' => 5,
            'feedback' => 'Fasilitas bagus, Montir, admin-nya dan pemiliknya juga ramah. harga terbaik',
            'show' => false,
        ],
    ]);

    return view('admin.manage-feedback', compact('ulasan'));
});

Route::get('/kelola-chat', function () {
    $path = resource_path('views/admin/data/chat-sessions.json');

    $json = File::get($path);
    $sessions = json_decode($json);

    return view('admin.manage-chat', compact('sessions'));
});

Route::get('/kelola-chat/session/{id}', function ($id) {
    $allChats = json_decode(File::get(resource_path('views/admin/data/chat.json')));
    $chats = collect($allChats)->where('id_chat_session', (int) $id)->values();

    // Ambil expired_at dari chat-session.json
    $allSessions = json_decode(File::get(resource_path('views/admin/data/chat-sessions.json')));
    $session = collect($allSessions)->firstWhere('id', (int) $id);
    $expiredAt = $session->expired_at ?? null;

    return response()->json([
        'chats' => $chats,
        'expired_at' => $expiredAt,
    ]);
});



/*
|--------------------------------------------------------------------------
| Route Maps & Kontak
|--------------------------------------------------------------------------
*/
Route::get('/kelola-maps', function () {
    return view('admin.manage-maps');
});

Route::get('/kelola-kontak', function () {
    return view('admin.manage-contact');
});



/*
|--------------------------------------------------------------------------
| Route Pemasukan
|--------------------------------------------------------------------------
*/
Route::get('/kelola-pemasukan', function () {
    return view('admin.manage-revenue');
});

Route::get('/tambah-pemasukan', function () {
    return view('admin.form-revenue', [
        'mode' => 'create',
    ]);
});

Route::get('/ubah-pemasukan/{id}', function () {
    return view('admin.form-revenue', [
        'mode' => 'edit',
    ]);
});



/*
|--------------------------------------------------------------------------
| Route Pengeluaran
|--------------------------------------------------------------------------
*/
Route::get('/kelola-pengeluaran', function () {
    return view('admin.manage-expense');
});

Route::get('/tambah-pengeluaran', function () {
    return view('admin.form-expense', [
        'mode' => 'create',
    ]);
});

Route::get('/ubah-pengeluaran/{id}', function () {
    return view('admin.form-expense', [
        'mode' => 'edit',
    ]);
});




Route::post('/entry-store', function () {
    return view('admin.form-service-entry');
})->name('entry.store');

Route::put('/entry-update', function () {
    return view('admin.form-service-entry');
})->name('entry.update');

