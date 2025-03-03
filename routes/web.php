<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('main.index');
});

Route::get('/layanan', function () {
    return view('main.layanan');
});

Route::get('/ulasan', function () {
    return view('main.index');
});

Route::get('/kontak', function () {
    return view('main.kontak');
});

Route::get('/dashboard', function () {
    return view('admin.index');
});
