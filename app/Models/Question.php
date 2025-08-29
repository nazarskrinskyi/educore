<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['test_id', 'question_text', 'question_type', 'image_path', 'video_path', 'audio_path'];

    protected $appends = ['audio_url', 'image_url', 'video_url'];

    public function getAudioUrlAttribute(): string
    {
        return $this->audio_path ? Storage::url($this->audio_path) : '';
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image_path ? Storage::url($this->image_path) : '';
    }

    public function getVideoUrlAttribute(): string
    {
        return $this->video_path ? Storage::url($this->video_path) : '';
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(Test::class);
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class);
    }
}
