<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\CourseProgressController;
use App\Http\Controllers\StripeWebhookController;
use App\Http\Controllers\TelegramController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('contact', [ContactMessageController::class, 'store'])->name('contact.store');

Route::post('stripe/webhook', [StripeWebhookController::class, 'handle']);
Route::post('telegram/webhook', [TelegramController::class, 'webhook']);

Route::get('courses/{course}/progress', [CourseProgressController::class, 'show']);

Route::get('cart', [CartController::class, 'index'])->name('cart.index');
Route::post('cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('checkout/order', [CartController::class, 'storeOrder'])->name('checkout.order');
