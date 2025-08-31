<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\CartEnum;
use App\Enums\CourseLevelEnum;
use App\Models\Course;
use App\Repositories\Order\OrderRepositoryInterface;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

readonly class CartService
{
    public function __construct(private OrderRepositoryInterface $orderRepository)
    {
    }

    /**
     * Get the current cart from session
     */
    public function getCart(): array
    {
        return Session::get(CartEnum::CART_SESSION_KEY->value, []);
    }

    /**
     * Save cart to session
     */
    public function saveCart(array $cart): void
    {
        Session::put(CartEnum::CART_SESSION_KEY->value, $cart);
    }

    public function assignCourseData(Course $course, ?int $id): array
    {
        return [
            'id' => $id,
            'name' => $course->title,
            'price' => $course->price / 100,
            'image' => Storage::url($course->image_path),
            'instructor' => $course->instructor?->name ?? 'Unknown',
            'rating' => round((int) $course->reviews()->avg('rating') ?? 0, 1),
            'reviews' => $course->reviews()->count(),
            'duration' => $course->duration,
            'is_free' => $course->is_free,
            'lessons' => $course->sections->map(fn($section) => $section?->lessons()->count())->sum(),
            'level' => CourseLevelEnum::from((int)$course->level)->name
        ];
    }

    /**
     * Calculate total cart amount
     */
    public function calculateTotal(array $cart): float
    {
        return array_reduce($cart, function (float $total, array $item) {
            return $total + $item['price'];
        }, 0);
    }

    public function storeOrder(string $paymentIntentId, array $cart): void
    {
        $total = $this->calculateTotal($cart);

        $this->orderRepository->create($paymentIntentId, $cart, $total);
    }
}
