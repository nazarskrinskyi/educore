<?php

namespace App\Enums;

enum CartEnum: string
{
    case CART_SESSION_KEY = 'cart';

    case CURRENCY = 'uah';

    case ORDER_STATUS_PENDING = 'pending';

    case ORDER_STATUS_PAID = 'paid';

    case ORDER_STATUS_FAILED = 'failed';

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
