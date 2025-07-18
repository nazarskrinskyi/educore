<?php

namespace App\Policies;

use App\Models\Test;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TestPolicy
{
    public function view(User $user): bool
    {
        return $user->hasRole(['admin', 'instructor', 'student']);
    }

    public function take(User $user): bool
    {
        return $user->hasRole('student');
    }

    public function create(User $user): bool
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
