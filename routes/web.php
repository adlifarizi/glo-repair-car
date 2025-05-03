<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Route Home
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('main.index')->with([
        'pusherKey' => config('broadcasting.connections.pusher.key'),
        'pusherCluster' => config('broadcasting.connections.pusher.options.cluster')
    ]);
});



/*
|--------------------------------------------------------------------------
| Route Layanan
|--------------------------------------------------------------------------
*/
Route::get('/layanan', function () {
    return view('main.layanan')->with([
        'pusherKey' => config('broadcasting.connections.pusher.key'),
        'pusherCluster' => config('broadcasting.connections.pusher.options.cluster')
    ]);
});



/*
|--------------------------------------------------------------------------
| Route Ulasan
|--------------------------------------------------------------------------
*/
Route::get('/ulasan', function () {
    return view('main.ulasan')->with([
        'pusherKey' => config('broadcasting.connections.pusher.key'),
        'pusherCluster' => config('broadcasting.connections.pusher.options.cluster')
    ]);
});



/*
|--------------------------------------------------------------------------
| Route Kontak
|--------------------------------------------------------------------------
*/
Route::get('/kontak', function () {
    return view('main.kontak')->with([
        'pusherKey' => config('broadcasting.connections.pusher.key'),
        'pusherCluster' => config('broadcasting.connections.pusher.options.cluster')
    ]);
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
    return view('admin.manage-chat')->with([
        'pusherKey' => config('broadcasting.connections.pusher.key'),
        'pusherCluster' => config('broadcasting.connections.pusher.options.cluster')
    ]);;
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