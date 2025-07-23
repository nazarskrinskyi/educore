<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function view(User $user, User $target): bool
    {
        return $user->hasRole('admin') || $user->id === $target->id;
    }

    public function manage(User $user): bool
    {
        return $user->hasRole('admin');
    }
}
