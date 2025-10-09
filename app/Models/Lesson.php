<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Storage;

/**
 * @property mixed $id
 * @property mixed $image_path
 * @property mixed $video_path
 * @property mixed $section
 */
class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id', 'title', 'content', 'video_path', 'image_path', 'is_published', 'views', 'slug',
    ];

    protected $appends = ['image_url', 'video_url', 'completed_at'];

    public function getCompletedAtAttribute()
    {
        if (!auth()->check()) return null;

        return $this->users()
            ->where('user_id', auth()->id())
            ->first()?->pivot->completed_at;
    }

    public function lessonsComments(): HasMany
    {
        return $this->hasMany(LessonComment::class);
    }

    public function Section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'lesson_user')->withPivot('completed_at');
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image_path ? Storage::url($this->image_path) : '';
    }

    public function getVideoUrlAttribute(): string
    {
        return $this->video_path ? Storage::url($this->video_path) : '';
    }
}
