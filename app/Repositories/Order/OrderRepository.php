<?php

declare(strict_types=1);

namespace App\Repositories\Order;

use App\Enums\CartEnum;
use App\Models\Order;

class OrderRepository implements OrderRepositoryInterface
{
    public function create(string $paymentIntentId, array $cart, float $total): void
    {
        $order = Order::create([
            'user_id' => auth()?->id(),
            'stripe_payment_id' => $paymentIntentId,
            'amount' => $total,
            'status' => CartEnum::ORDER_STATUS_PAID->value,
        ]);

        foreach ($cart as $item) {
            $order->items()->create([
                'course_id' => $item['id'],
                'price' => $item['price'],
            ]);
        }
    }
}
