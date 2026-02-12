<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\IntegrationController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return redirect()->route('reviews.index');
    })->name('dashboard');

    Route::get('/reviews', [IntegrationController::class, 'reviews'])->name('reviews.index');
    Route::get('/settings', [IntegrationController::class, 'settings'])->name('settings.edit');
    Route::post('/settings', [IntegrationController::class, 'store'])->name('settings.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
