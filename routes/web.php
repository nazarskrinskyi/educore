<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Admin\CertificateAdminController;
use App\Http\Controllers\Admin\CommentAdminController;
use App\Http\Controllers\Admin\ContactMessageAdminController;
use App\Http\Controllers\Admin\CourseAdminController;
use App\Http\Controllers\Admin\TestAdminController;
use App\Http\Controllers\Admin\UserAdminController;
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

Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function () {
    Route::resource('users', UserAdminController::class)->except(['create', 'store']);

    Route::resource('courses', CourseAdminController::class)->except(['create', 'store']);

    Route::get('/comments', [CommentAdminController::class, 'index']);
    Route::put('/comments/{id}/approve', [CommentAdminController::class, 'approve']);
    Route::put('/comments/{id}/reject', [CommentAdminController::class, 'reject']);
    Route::delete('/comments/{id}', [CommentAdminController::class, 'destroy']);

    Route::get('/certificates', [CertificateAdminController::class, 'index']);
    Route::get('/tests', [TestAdminController::class, 'index']);

    Route::get('/contact-us', [ContactMessageAdminController::class, 'index']);
    Route::get('/contact-us/{id}', [ContactMessageAdminController::class, 'show']);
});


require __DIR__.'/auth.php';
