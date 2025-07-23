<?php

namespace App\Policies;

use App\Models\User;

class LessonPolicy
{
    public function view(User $user): bool
    {
        return $user->hasRole(['admin', 'instructor', 'student']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole('instructor');
    }

    public function update(User $user): bool
    {
        return $user->hasRole('instructor');
    }

    public function delete(User $user): bool
    {
        return $user->hasRole('admin');
    }
}
