<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class LessonResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'views' => $this->views,
            'completed_at' => $this->completed_at,
            'image_url' => $this->image_path ? Storage::url($this->image_path) : null,
            'video_url' => $this->video_path ? Storage::url($this->video_path) : null,
            'reviews' => $this->lessonsComments->map(fn($review) => [
                'id' => $review->id,
                'user_id' => $review->user_id,
                'user' => ['name' => $review->user->name],
                'comment' => $review->comment,
                'lesson_id' => $review->lesson_id,
            ]),
            'tests' => $this->tests->map(fn($test) => [
                'id' => $test->id,
                'title' => $test->title,
                'slug' => $test->slug,
                'lesson_id' => $test->lesson_id,
                'description' => $test->description,
                'duration' => $test->duration,
                'image_url' => $test->image_url,
            ]),
        ];
    }
}
