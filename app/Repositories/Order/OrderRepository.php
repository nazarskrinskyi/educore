<?php

declare(strict_types=1);

namespace App\Repositories\Order;

use App\Enums\CartEnum;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderRepository implements OrderRepositoryInterface
{
    public function create(string $paymentIntentId, array $cart, float $total): void
    {
        DB::transaction(function () use ($paymentIntentId, $cart, $total) {
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
        });
    }
}
