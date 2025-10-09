<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

/**
 * @method static findOrFail(mixed $course_id)
 * @method static find(mixed $courseId)
 * @method static min(string $string)
 * @method static max(string $string)
 * @method static whereDate(string $string, \Illuminate\Support\Carbon $subDay)
 * @property int|mixed $price
 * @property mixed|string $video_path
 * @property mixed|string $image_path
 * @property string|mixed $title
 * @property numeric|mixed $duration
 * @property bool|mixed $is_free
 * @property string|mixed $level
 * @property false|mixed $owned
 * @property bool|mixed $in_cart
 * @property mixed $sections
 * @property mixed $id
 * @property mixed $instructor
 */
class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'slug', 'description', 'price', 'category_id', 'instructor_id',
        'image_path', 'video_path', 'is_published', 'views', 'is_free', 'level', 'duration'
    ];

    protected $appends = ['price_formatted', 'image_url', 'video_url'];

    public function lessons(): HasManyThrough
    {
        return $this->hasManyThrough(Lesson::class, Section::class);
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_user')
            ->withPivot(['enrolled_at', 'progress_percent'])
            ->withTimestamps();
    }

    public function isUserEnrolled(int $userId): bool
    {
        return $this->users()->where('user_id', $userId)->exists();
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function getPriceFormattedAttribute(): float
    {
        return $this->price / 100;
    }

    public function getImageUrlAttribute(): string
    {
        return $this->image_path ? Storage::url($this->image_path) : '';
    }

    public function getVideoUrlAttribute(): string
    {
        return $this->video_path ? Storage::url($this->video_path) : '';
    }

    public function scopeFilter(Builder $query, Request $request): Builder
    {
        return $query
            ->when($request->search, fn($q) =>
                $q->where(fn($sub) =>
                $sub->where('title', 'like', "%$request->search%")
                    ->orWhere('description', 'like', "%$request->search%")
                )
            )
            ->when($request->difficulty, fn($q) =>
                $q->where('level', $request->difficulty)
            )
            ->when($request->category, fn($q) =>
                $q->where('category_id', $request->category)
            )
            ->when($request->sorting, function ($q) use ($request) {
                match ($request->sorting) {
                    'rating_asc' => $q->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'asc'),
                    'rating_desc' => $q->withAvg('reviews', 'rating')->orderBy('reviews_avg_rating', 'desc'),
                    'price_asc' => $q->orderBy('price', 'asc'),
                    'price_desc' => $q->orderBy('price', 'desc'),
                    'newest' => $q->orderBy('created_at', 'desc'),
                    default => null,
                };
            })
            ->when($request->has('price_min') && $request->price_min !== '', fn($q) =>
                $q->where('price', '>=', $request->price_min * 100)
            )
            ->when($request->has('price_max') && $request->price_max !== '', fn($q) =>
                $q->where('price', '<=', $request->price_max * 100)
            )
            ->when($request->boolean('is_free'), fn($q) =>
                $q->where('is_free', true)
            );
    }
}
