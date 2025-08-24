<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_id', 'title', 'content', 'video_path', 'image_path', 'is_published', 'views', 'slug'
    ];

    public function Section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function tests(): HasMany
    {
        return $this->hasMany(Test::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'lesson_user')->withPivot('completed_at');
    }
}
