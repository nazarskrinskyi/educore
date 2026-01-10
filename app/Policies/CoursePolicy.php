<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    /**
     * Determine if the user can view any courses
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the user can view the course
     */
    public function view(User $user, Course $course): bool
    {
        return $user->isAdmin() || $course->user_id === $user->id;
    }

    /**
     * Determine if the user can create courses
     */
    public function create(User $user): bool
    {
        return $user->isInstructor() || $user->isAdmin();
    }

    /**
     * Determine if the user can update the course
     */
    public function update(User $user, Course $course): bool
    {
        return $user->isAdmin() || $course->user_id === $user->id;
    }

    /**
     * Determine if the user can delete the course
     */
    public function delete(User $user, Course $course): bool
    {
        return $user->isAdmin() || $course->user_id === $user->id;
    }

    /**
     * Determine if the user can restore the course
     */
    public function restore(User $user, Course $course): bool
    {
        return $user->isAdmin();
    }

    /**
     * Determine if the user can permanently delete the course
     */
    public function forceDelete(User $user, Course $course): bool
    {
        return $user->isAdmin();
    }
}
