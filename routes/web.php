<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LessonCommentController;
use App\Http\Controllers\LessonCompletionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseReviewController;
use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', HomeController::class)->name('dashboard');

Route::get('/about', AboutController::class)->name('about');

Route::get('/contact', [ContactMessageController::class, 'index'])->name('contact');

Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');

Route::get('api/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('api/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

Route::middleware('verified')->group(function () {
    Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');
    Route::get('/courses/{course:slug}/lessons/{lesson:slug}', [CourseController::class, 'enrollShow'])->name('courses.player');

    Route::post('/courses/reviews/store', [CourseReviewController::class, 'store'])->name('courses.reviews.store');
    Route::put('/courses/reviews/{review:id}', [CourseReviewController::class, 'update'])->name('courses.reviews.update');
    Route::delete('/courses/reviews/{review:id}', [CourseReviewController::class, 'destroy'])->name('courses.reviews.destroy');

    Route::post('/lessons/reviews/store', [LessonCommentController::class, 'store'])->name('lessons.reviews.store');
    Route::put('/lessons/reviews/{review:id}', [LessonCommentController::class, 'update'])->name('lessons.reviews.update');
    Route::delete('/lessons/reviews/{review:id}', [LessonCommentController::class, 'destroy'])->name('lessons.reviews.destroy');

    Route::post('/lessons/{lesson}/toggle', [LessonCompletionController::class, 'toggle'])
        ->name('lessons.toggle')
        ->middleware('auth');

    Route::post('/lessons/{lesson}/complete', [LessonCompletionController::class, 'complete'])
        ->name('lessons.complete')
        ->middleware('auth');

    Route::get('/certificates/{id}', [CertificateController::class, 'show'])->name('certificates.show');

    Route::get('/tests/{test:slug}', [TestController::class, 'show'])->name('tests.show');
    Route::post('/tests/{test:id}/progress', [TestController::class, 'saveProgress'])->name('tests.progress');
    Route::get('/tests/{test:id}/progress', [TestController::class, 'getProgress'])->name('tests.progress.get');
    Route::post('/tests/{test:id}/submit', [TestController::class, 'submit'])->name('tests.submit');
    Route::get('/tests/{test:id}/result', [TestController::class, 'result'])->name('tests.result');

    Route::get('/checkout/success', function () {
        return Inertia::render('Cart/Success');
    })->name('checkout.success');
    Route::get('/checkout/cancel', function () {
        return Inertia::render('Cart/Cancel');
    })->name('checkout.cancel');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::get('/profile/show-tests', [ProfileController::class, 'showTests'])->name('profile.show.tests');
    Route::get('/profile/show-courses', [ProfileController::class, 'showCourses'])->name('profile.show.courses');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
