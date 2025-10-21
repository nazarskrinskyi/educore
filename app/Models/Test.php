<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

/**
 * @property mixed $image_path
 * @property mixed $id
 * @property mixed $questions
 * @property mixed $lesson
 * @property mixed $course
 */
class Test extends Model
{
    use HasFactory;

    protected $fillable = ['lesson_id', 'user_id', 'course_id', 'pass_percentage', 'description', 'title', 'duration', 'slug', 'image_path'];

    protected $appends = ['image_url'];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
    }

    public function testAttempts(): HasMany
    {
        return $this->hasMany(TestAttempt::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function results(): HasMany
    {
        return $this->hasMany(TestResult::class);
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image_path ? Storage::url($this->image_path) : '';
    }

    public function isPassed(): bool
    {
        return $this->results()->where('user_id', auth()->id())->exists();
    }

    public function isSuccessfullyPassed(): bool
    {
        return $this->results()->where('user_id', auth()->id())->where('passed', true)->exists();
    }

    public function getTestAttempts(): Collection
    {
        return $this->testAttempts()->where('user_id', auth()->id())->get();
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
