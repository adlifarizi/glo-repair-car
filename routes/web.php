<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Route Home
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('main.index');
});



/*
|--------------------------------------------------------------------------
| Route Layanan
|--------------------------------------------------------------------------
*/
Route::get('/layanan', function () {
    return view('main.layanan');
});



/*
|--------------------------------------------------------------------------
| Route Ulasan
|--------------------------------------------------------------------------
*/
Route::get('/ulasan', function () {
    return view('main.ulasan');
});



/*
|--------------------------------------------------------------------------
| Route Kontak
|--------------------------------------------------------------------------
*/
Route::get('/kontak', function () {
    return view('main.kontak');
});



/*
|--------------------------------------------------------------------------
| Route Login
|--------------------------------------------------------------------------
*/
// Admin Route
Route::get('/login', function () {
    return view('admin.layouts.login');
});



/*
|--------------------------------------------------------------------------
| Route Dashboard
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return view('admin.index');
});

Route::get('/generate-laporan', [AdminController::class, 'generatePDF']);



/*
|--------------------------------------------------------------------------
| Route Kelola Entri Servis
|--------------------------------------------------------------------------
*/
Route::get('/kelola-entri-servis', function () {
    return view('admin.manage-service-entries');
});

Route::get('/tambah-entri-servis', function () {
    return view('admin.form-service-entry', [
        'mode' => 'create',
    ]);
});

Route::get('/ubah-entri-servis/{id}', function () {
    return view('admin.form-service-entry', [
        'mode' => 'edit',
    ]);
});



/*
|--------------------------------------------------------------------------
| Route Kelola Ulasan
|--------------------------------------------------------------------------
*/
Route::get('/kelola-ulasan', function () {
    return view('admin.manage-feedback');
});



/*
|--------------------------------------------------------------------------
| Route Kelola Chat
|--------------------------------------------------------------------------
*/
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
| Route Kelola Maps & Kontak
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
| Route Kelola Pemasukan
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
| Route Kelola Pengeluaran
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
