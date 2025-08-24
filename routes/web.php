<?php

use App\Http\Controllers\AboutController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', HomeController::class)->name('dashboard');

Route::get('/about', AboutController::class)->name('about');

Route::get('/courses', [ServiceController::class, 'index'])->name('services');

Route::get('/contact', [ContactMessageController::class, 'index'])->name('contact');

Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/{slug}', [CourseController::class, 'show'])->name('courses.show');

Route::get('/api/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/api/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout/order', [CartController::class, 'storeOrder'])->name('checkout.order');
Route::get('/checkout/success', function () {
    return Inertia::render('Cart/Success');
})->name('checkout.success');
Route::get('/checkout/cancel', function () {
    return Inertia::render('Cart/Cancel');
})->name('checkout.cancel');

Route::post('/stripe/webhook', [StripeWebhookController::class, 'handle']);

Route::middleware('verified')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
