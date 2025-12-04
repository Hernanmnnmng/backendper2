<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LeverancierController;
use App\Http\Controllers\MagazijnController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/magazijn', [MagazijnController::class, 'index'])->name('magazijn.index');
Route::get('/magazijn/{productId}/levering-info', [MagazijnController::class, 'leveringInfo'])->name('magazijn.levering-info');
Route::get('/magazijn/{productId}/allergenen-info', [MagazijnController::class, 'allergenenInfo'])->name('magazijn.allergenen-info');

// Leverancier routes (User Story 01 & 02 + CRUD)
Route::middleware('auth')->group(function () {
    // CRUD routes
    Route::get('/leveranciers', [LeverancierController::class, 'index'])->name('leverancier.index');
    Route::get('/leveranciers/create', [LeverancierController::class, 'create'])->name('leverancier.create');
    Route::post('/leveranciers', [LeverancierController::class, 'store'])->name('leverancier.store');
    Route::get('/leveranciers/{id}/edit', [LeverancierController::class, 'edit'])->name('leverancier.edit');
    Route::put('/leveranciers/{id}', [LeverancierController::class, 'update'])->name('leverancier.update');
    Route::delete('/leveranciers/{id}', [LeverancierController::class, 'destroy'])->name('leverancier.destroy');
    
    // User Story routes
    Route::get('/leveranciers/{leverancierId}/producten', [LeverancierController::class, 'showProducten'])->name('leverancier.producten');
    Route::get('/leveranciers/{leverancierId}/producten/{productId}/levering-toevoegen', [LeverancierController::class, 'showAddLevering'])->name('leverancier.add-levering');
    Route::post('/leveranciers/{leverancierId}/producten/{productId}/levering-toevoegen', [LeverancierController::class, 'storeLevering'])->name('leverancier.store-levering');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
