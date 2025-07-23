<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Result extends Model
{
    protected $fillable = ['user_id', 'test_id', 'test_answer_id', 'is_correct'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function answer(): BelongsTo
    {
        return $this->belongsTo(TestAnswer::class, 'test_answer_id');
    }
}
