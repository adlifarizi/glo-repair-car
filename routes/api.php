<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\EntriServisController;
use App\Http\Controllers\FeedbackController;
use App\Http\Controllers\KontakController;
use App\Http\Controllers\MapsController;
use App\Http\Controllers\PengeluaranController;
use App\Http\Controllers\PemasukanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/*
|--------------------------------------------------------------------------
| API tanpa access token
|--------------------------------------------------------------------------
*/
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::get('/check-progress', [EntriServisController::class, 'showByPlatNo']);

Route::get('/maps', [MapsController::class, 'show']);

Route::get('/kontak', [KontakController::class, 'show']);

Route::get('/feedback-show', [FeedbackController::class, 'getVisibleFeedback']);
Route::get('/feedback', [FeedbackController::class, 'getAllFeedback']);
Route::post('/feedback', [FeedbackController::class, 'store']);

Route::post('/chat', [ChatController::class, 'store']);
Route::get('/chat-sessions', [ChatController::class, 'getAllChatSessions']);
Route::get('/chat-by-session/{session_id}', [ChatController::class, 'getChatsBySession']);



/*
|--------------------------------------------------------------------------
| API Yang membutuhkan access token
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/get-dashboard-data', [AdminController::class, 'getDashboardData']);

    Route::get('/entri-servis', [EntriServisController::class, 'show']);
    Route::get('/entri-servis/{id}', [EntriServisController::class, 'showByID']);
    Route::post('/entri-servis', [EntriServisController::class, 'store']);
    Route::put('/entri-servis/{id}', [EntriServisController::class, 'update']);
    Route::delete('/entri-servis/{id}', [EntriServisController::class, 'delete']);

    Route::put('/maps', [MapsController::class, 'update']);

    Route::put('/kontak', [KontakController::class, 'update']);

    Route::put('feedback/{id}/toggle-show', [FeedbackController::class, 'toggleShow']);
    Route::delete('/feedback/{id}', [FeedbackController::class, 'delete']);

    Route::post('/pengeluaran', [PengeluaranController::class, 'store']);
    Route::put('/pengeluaran/{id}', [PengeluaranController::class, 'update']);
    Route::get('/pengeluaran/{id}', [PengeluaranController::class, 'showById']);
    Route::get('/pengeluaran', [PengeluaranController::class, 'show']);
    Route::delete('/pengeluaran/{id}', [PengeluaranController::class, 'destroy']);

    Route::post('/pemasukan', [PemasukanController::class, 'store']);
    Route::put('/pemasukan/{id}', [PemasukanController::class, 'update']);
    Route::get('/pemasukan/{id}', [PemasukanController::class, 'showById']);
    Route::get('/pemasukan', [PemasukanController::class, 'show']);
    Route::delete('/pemasukan/{id}', [PemasukanController::class, 'destroy']);
});

