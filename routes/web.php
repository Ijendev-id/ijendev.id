<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman depan (tetap welcome)
Route::get('/', function () {
    return view('welcome');
});

// Auth scaffolding (login, register, reset password, logout, dll)
Auth::routes();

/*
|--------------------------------------------------------------------------
| Protected Area (wajib login)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Alias lama: /dashboard -> admin.dashboard (tetap bisa dipakai di sidebar)
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');

    // Admin area
    Route::prefix('admin')->name('admin.')->group(function () {
        // Dashboard SB Admin 2 (statis)
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

        // CRUD Data Klien & Proyek
        Route::resource('clients', ClientController::class);
        Route::resource('projects', ProjectController::class);
    });
});

/*
|--------------------------------------------------------------------------
| Kompatibilitas default Laravel UI
|--------------------------------------------------------------------------
*/
// /home bawaan diarahkan ke dashboard admin
Route::get('/home', function () {
    return redirect()->route('admin.dashboard');
})->name('home');

// (Opsional) Fallback 404 custom
// Route::fallback(fn () => response()->view('errors.404', [], 404));
