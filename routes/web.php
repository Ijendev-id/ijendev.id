<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProjectController;

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

    // /dashboard akan mengarahkan berdasarkan role user yang sedang login
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user && $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('user.dashboard');
    })->name('dashboard');

    // Admin area: hanya untuk yang punya role = 'admin'
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {
        // Dashboard SB Admin 2 (statis)
        Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

        // CRUD Data Klien & Proyek (hanya admin)
        Route::resource('clients', ClientController::class);
        Route::resource('projects', ProjectController::class);

        // AJAX search (GET) dan migrasi (POST) — **nempel di dalam group admin**
        Route::get('clients/search-candidates', [ClientController::class, 'searchCandidates'])
            ->name('clients.searchCandidates');

        Route::post('clients/migrate-from-user', [ClientController::class, 'migrateFromUser'])
            ->name('clients.migrateFromUser');
    });

    // Area untuk user biasa
    Route::prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserController::class, 'index'])->name('dashboard');

        // Proyek Saya
        Route::get('/projects', [UserProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/{project}', [UserProjectController::class, 'show'])->name('projects.show');
    });
});

/*
|--------------------------------------------------------------------------
| Kompatibilitas default Laravel UI
|--------------------------------------------------------------------------
*/
Route::get('/home', function () {
    return redirect()->route('dashboard');
})->name('home');

// Route fallback jika perlu
// Route::fallback(fn () => response()->view('errors.404', [], 404));
