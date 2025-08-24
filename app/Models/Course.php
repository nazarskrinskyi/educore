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

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'course_user');
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
            ->when($request->search, fn($q) => $q->where(fn($sub) => $sub->where('title', 'like', "%$request->search%")
                ->orWhere('description', 'like', "%$request->search%")))
            ->when($request->category, fn($q) => $q->where('category_id', $request->category))
            ->when($request->rating, fn($q) => $q->whereHas('reviews', fn($sub) => $sub->where('rating', '>=', $request->rating)))
            ->when($request->price_min, fn($q) => $q->where('price', '>=', $request->price_min))
            ->when($request->price_max, fn($q) => $q->where('price', '<=', $request->price_max));
    }
}
