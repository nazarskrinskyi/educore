<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'lesson_id' => $this->lesson_id,
            'is_passed' => $this->is_passed(),
            'description' => $this->description,
            'duration' => $this->duration,
            'image_url' => $this->image_url,
            'questions' => $this->questions->map(fn($question) => [
                'id' => $question->id,
                'question_text' => $question->question_text,
                'question_type' => $question->question_type,
                'image_url' => $question->image_url,
                'video_url' => $question->video_url,
                'audio_url' => $question->audio_url,
                'answers' => $question->answers->map(fn($answer) => [
                    'id' => $answer->id,
                    'question_id' => $answer->question_id,
                    'bool' => $answer->bool,
                    'answer_text' => $answer->answer_text,
                    'image_url' => $question->image_url,
                    'video_url' => $question->video_url,
                    'audio_url' => $question->audio_url,
                    'is_correct' => $answer->is_correct,
                ])
            ]),
            'lesson' => [
                'slug' => $this->lesson->slug,
                'title' => $this->lesson->title
            ],
            'course' => [
                'slug' => $this->course->slug,
                'title' => $this->course->title
            ]
        ];
    }
}
