<?php

namespace App\Http\Resources;

use App\Models\CourseUser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CourseResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'slug' => $this->slug,
            'image_url' => $this->image_path ? Storage::url($this->image_path) : null,
            'is_free' => $this->is_free,
            'price_formatted' => $this->price / 100,
            'rating' => round($this->reviews()->avg('rating') ?? 0, 1),
            'reviews_count' => $this->reviews()->count(),
            'instructor' => ['name' => $this->instructor?->name ?? '—'],
            'category' => ['name' => $this->category?->name ?? '—'],
            'in_cart' => session()->has('cart.' . $this->id),
            'owned' => $request->user() ? CourseUser::where('course_id', $this->id)
                ->where('user_id', $request->user()->id)
                ->exists() : false,
            'users' => $this->users->map(fn($user) => [
                'name' => $user->id,
            ]),
            'tags' => $this->tags->map(fn($tag) => [
                'id' => $tag->id,
                'name' => $tag->name,
                'slug' => $tag->slug,
            ]),
            'reviews' => $this->reviews->map(fn($review) => [
                'id' => $review->id,
                'comment' => $review->comment,
                'user_id' => $review->user_id,
                'rating' => $review->rating,
                'created_at' => $review->created_at->diffForHumans(),
                'user' => ['name' => $review->user->name],
            ]),
            'sections' => $this->sections->map(fn($section) => [
                'id' => $section->id,
                'title' => $section->title,
                'lessons' => $section->lessons->map(fn($lesson) => [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                    'slug' => $lesson->slug,
                    'views' => $lesson->views,
                    'image_url' => $lesson->image_url,
                    'video_url' => $lesson->video_url,
                ]),
            ]),
        ];
    }
}
