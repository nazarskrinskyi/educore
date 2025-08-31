<?php

declare(strict_types=1);

namespace App\Repositories\Order;

interface OrderRepositoryInterface
{
    public function create(string $paymentIntentId, array $cart, float $total): void;
}
