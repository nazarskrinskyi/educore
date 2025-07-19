<?php

namespace App\Policies;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LessonPolicy
{
    public function view(User $user): bool
    {
        return $user->hasRole(['admin', 'instructor', 'student']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin', 'instructor');
    }

    public function show(User $user): bool
    {
        return $user->hasRole('admin', 'instructor');
    }

    public function update(User $user): bool
    {
        return $user->hasRole('admin', 'instructor');
    }

    public function delete(User $user): bool
    {
        return $user->hasRole('admin', 'instructor');
    }
}
