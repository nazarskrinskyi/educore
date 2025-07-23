<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function view(User $user, Course $course): bool
    {
        return $user->hasRole(['admin', 'instructor', 'student']);
    }

    public function create(User $user): bool
    {
        return $user->hasRole(['admin', 'instructor']);
    }

    public function update(User $user, Course $course): bool
    {
        return $user->hasRole(['admin', 'instructor']);
    }

    public function delete(User $user, Course $course): bool
    {
        return $user->hasRole(['admin', 'instructor']);
    }

    public function restore(User $user, Course $course): bool
    {
        return $user->hasRole(['admin', 'instructor']);
    }
}
