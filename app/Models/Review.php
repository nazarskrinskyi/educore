<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method static create(array $validated)
 * @method static where(string $string, $id)
 */
class Review extends Model
{
    use HasFactory;

    protected $fillable = ['course_id', 'user_id', 'rating', 'comment'];

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
