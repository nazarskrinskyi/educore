<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

/**
 * @property mixed $image_path
 */
class Test extends Model
{
    use HasFactory;

    protected $fillable = ['lesson_id', 'course_id', 'description', 'title', 'duration', 'slug', 'image_path'];

    protected $appends = ['image_url'];

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(Lesson::class);
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

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
