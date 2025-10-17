<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id', 'slug'];

    public function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_tag');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
