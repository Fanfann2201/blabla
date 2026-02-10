<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PeminjamController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        $r = Auth::user()->role;
        if ($r = 'admin') return redirect()->route('admin.dashboard');
        if ($r = 'petugas') return redirect()->route('petugas.dashboard');
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    // default breeze loing
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ADMIN
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');

        // crud kategori
        Route::post('/admin/kategori', [AdminController::class, 'storeKategori'])->name('admin.kategori.store');
        Route::delete('/admin/kategori/{$id}', [AdminController::class, 'destoryKategori'])->name('admin.kategori.destroy');

        // crud User
        Route::post('/admin/user', [AdminController::class, 'storeUser'])->name('admin.user.store');
        Route::delete('/admin/user/{$id}', [AdminController::class, 'destoryUser'])->name('admin.user.destroy');

        // crud Alat
        Route::post('/admin/alat', [AdminController::class, 'storeAlat'])->name('admin.alat.store');
        Route::delete('/admin/alat/{$id}', [AdminController::class, 'destoryAlat'])->name('admin.alat.destroy');
    });


    // PETUGAS
    Route::middleware(['role:petugas'])->group(function () {
        Route::get('/petugas/dashboard', [PetugasController::class, 'index'])->name('petugas.dashboard');

        // Perhatikan ini pakai PATCH
        Route::patch('/petugas/approve/{id}', [PetugasController::class, 'approve'])->name('petugas.approve');
        Route::patch('/petugas/reject/{id}', [PetugasController::class, 'reject'])->name('petugas.reject');
        Route::patch('/petugas/return/{id}', [PetugasController::class, 'return'])->name('petugas.return');
    });
    // PEMINJAM
    Route::middleware(['role:peminjam'])->group(function () {
        Route::get('/dashboard', [PeminjamController::class, 'index'])->name('dashboard');
        Route::post('/pinjam', [PeminjamController::class, 'store'])->name('pinjam.store');
    });
});

require __DIR__ . '/auth.php';
