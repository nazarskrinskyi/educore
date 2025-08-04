<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use Illuminate\Support\Facades\Route;

Route::get('/', HomeController::class)->name('dashboard');

Route::get('/about', AboutController::class)->name('about');

Route::get('/services', [ServiceController::class, 'index'])->name('services');

Route::get('/contact', [ContactMessageController::class, 'index'])->name('contact');

Route::get('/modules', [ServiceController::class, 'index'])->name('modules');

Route::get('/api/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/api/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
