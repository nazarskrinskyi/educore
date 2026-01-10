<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'course_id', 'price'];

    protected $casts = [
        'price' => 'integer',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the user who owns this order item through the order
     */
    public function user(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            Order::class,
            'id',           // Foreign key on orders table
            'id',           // Foreign key on users table
            'order_id',     // Local key on order_items table
            'user_id'       // Local key on orders table
        );
    }
}
