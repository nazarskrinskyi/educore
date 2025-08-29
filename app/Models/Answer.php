<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = ['question_id', 'answer_text', 'answer_image_path', 'answer_video_path', 'answer_audio_path', 'is_correct'];

    protected $appends = ['audio_url', 'image_url', 'video_url'];

    public function getAudioUrlAttribute(): string
    {
        return $this->answer_audio ? Storage::url($this->answer_audio) : '';
    }

    public function getImageUrlAttribute(): string
    {
        return $this->answer_image ? Storage::url($this->answer_image) : '';
    }

    public function getVideoUrlAttribute(): string
    {
        return $this->answer_video ? Storage::url($this->answer_video) : '';
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}
