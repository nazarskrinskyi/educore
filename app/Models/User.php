<?php

namespace App\Models;

use App\Enums\RoleEnum;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static where(string $string, $email)
 * @method static updateOrCreate(array $array, array $array1)
 * @method static whereNotNull(string $string)
 * @method static find(int|string|null $id)
 * @property mixed $id
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    protected $fillable = [
        "name",
        "email",
        "password",
        "role",
        "telegram_username",
        "locale",
    ];

    protected $hidden = [
        "password",
        "remember_token",
    ];

    protected function casts(): array
    {
        return [
            "email_verified_at" => "datetime",
            "password" => "hashed",
            "role" => RoleEnum::class,
        ];
    }

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, "course_user")
            ->withPivot(["enrolled_at", "progress_percent"])
            ->withTimestamps();
    }

    public function lessons(): BelongsToMany
    {
        return $this->belongsToMany(Lesson::class, "lesson_user")
            ->withPivot("completed_at");
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, "user_id");
    }

    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
    }

    public function loginHistory(): HasMany
    {
        return $this->hasMany(LoginHistory::class);
    }

    public function wishlist(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check if user has admin role
     */
    public function isAdmin(): bool
    {
        return $this->role === RoleEnum::ADMIN;
    }

    /**
     * Check if user has instructor role
     */
    public function isInstructor(): bool
    {
        return $this->role === RoleEnum::INSTRUCTOR;
    }

    /**
     * Check if user has student role
     */
    public function isStudent(): bool
    {
        return $this->role === RoleEnum::STUDENT;
    }
}
