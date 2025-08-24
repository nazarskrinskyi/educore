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
            'id'             => $this->id,
            'title'          => $this->title,
            'slug'           => $this->slug,
            'image_url'      => $this->image_path ? Storage::url($this->image_path) : null,
            'is_free'        => $this->is_free,
            'price_formatted'=> $this->price / 100,
            'rating'         => round($this->reviews()->avg('rating') ?? 0, 1),
            'reviews_count'  => $this->reviews()->count(),
            'instructor'     => ['name' => $this->instructor?->name ?? '—'],
            'category'       => ['name' => $this->category?->name ?? '—'],
            'tags'           => $this->tags->map(fn($tag) => [
                'id' => $tag->id,
                'name' => $tag->name,
                'slug' => $tag->slug,
            ]),
            'owned' => $request->user() ? CourseUser::where('course_id', $this->id)
                ->where('user_id', $request->user()->id)
                ->exists() : false,
            'in_cart' => session()->has('cart.' . $this->id),
        ];
    }
}
