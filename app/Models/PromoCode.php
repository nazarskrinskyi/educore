<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PromoCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'discount_percent', 'max_uses', 'used_count', 'expires_at'
    ];

    protected array $dates = ['expires_at'];

    public function isValid(): bool
    {
        return $this->used_count < $this->max_uses && ($this->expires_at === null || $this->expires_at->isFuture());
    }
}
