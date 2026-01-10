<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\ConfirmablePasswordController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\Auth\Student\RegisteredStudentController;
use App\Http\Controllers\Auth\Student\AuthenticatedStudentController;
use App\Http\Controllers\Auth\Instructor\RegisteredInstructorController;
use App\Http\Controllers\Auth\Instructor\AuthenticatedInstructorController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::middleware('guest')->group(function () {
    // Legacy routes - redirect to student routes for backward compatibility
    Route::get('register', function () {
        return redirect()->route('student.register');
    })->name('register');

    Route::get('login', function () {
        return redirect()->route('student.login');
    })->name('login');

    // Student Authentication Routes
    Route::prefix('student')->group(function () {
        Route::get('register', [RegisteredStudentController::class, 'create'])
            ->name('student.register');

        Route::post('register', [RegisteredStudentController::class, 'store'])
            ->name('student.register');

        Route::get('login', [AuthenticatedStudentController::class, 'create'])
            ->name('student.login');

        Route::post('login', [AuthenticatedStudentController::class, 'store'])
            ->name('student.login');
    });

    // Instructor Authentication Routes
    Route::prefix('instructor')->group(function () {
        Route::get('register', [RegisteredInstructorController::class, 'create'])
            ->name('instructor.register');

        Route::post('register', [RegisteredInstructorController::class, 'store'])
            ->name('instructor.register');

        Route::get('login', [AuthenticatedInstructorController::class, 'create'])
            ->name('instructor.login');

        Route::post('login', [AuthenticatedInstructorController::class, 'store'])
            ->name('instructor.login');
    });

    // Password Reset Routes (shared by all users)
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store');
});

Route::middleware('auth')->group(function () {
    Route::get('verify-email', EmailVerificationPromptController::class)
        ->middleware('auth')->name('verification.notice');

    Route::get('/email/verify', function () {
        return Inertia::render('Auth/VerifyEmail');
    })->middleware('auth')->name('verification.notice');

    Route::get('verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::get('confirm-password', [ConfirmablePasswordController::class, 'show'])
        ->name('password.confirm');

    Route::post('confirm-password', [ConfirmablePasswordController::class, 'store']);

    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
});
