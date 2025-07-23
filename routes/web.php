<?php

use App\Http\Controllers\Admin\CertificateAdminController;
use App\Http\Controllers\Admin\CommentAdminController;
use App\Http\Controllers\Admin\ContactMessageAdminController;
use App\Http\Controllers\Admin\CourseAdminController;
use App\Http\Controllers\Admin\TestAdminController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (auth()->check()) {
        return Inertia::render('Dashboard');
    }

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('dashboard');

Route::middleware('auth')->group(function () {
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
