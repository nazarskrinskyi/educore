<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TestAttemptAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'test_attempt_id', 'question_id', 'selected_answer_id',
        'selected_answer_ids', 'bool', 'text'
    ];

    protected $casts = [
        'selected_answer_ids' => 'array'
    ];

    public function attempt(): BelongsTo
    {
        return $this->belongsTo(TestAttempt::class, 'test_attempt_id');
    }
}
