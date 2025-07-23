<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Lesson extends Model
{
    protected $fillable = ['title', 'video_url', 'section_id'];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function test(): HasOne
    {
        return $this->hasOne(Test::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(LessonComment::class);
    }
}
