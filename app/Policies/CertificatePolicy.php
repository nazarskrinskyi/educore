<?php

namespace App\Policies;

use App\Models\User;

class CertificatePolicy
{
    public function view(User $user): bool
    {
        return $user->hasRole(['student', 'admin']);
    }

    public function generate(User $user): bool
    {
        return $user->hasRole('student');
    }
}
