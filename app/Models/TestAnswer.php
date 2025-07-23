<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestAnswer extends Model
{
    protected $fillable = ['test_id', 'answer_text', 'is_correct'];

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }
}
