<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthorizationService
{
    /**
     * Get the currently authenticated user
     */
    public function user(): ?User
    {
        return Auth::user();
    }

    /**
     * Get the current user's ID
     */
    public function userId(): ?int
    {
        return Auth::id();
    }

    /**
     * Check if the current user is an admin
     */
    public function isAdmin(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    /**
     * Check if the current user is an instructor
     */
    public function isInstructor(): bool
    {
        return $this->user()?->isInstructor() ?? false;
    }

    /**
     * Check if the current user is a student
     */
    public function isStudent(): bool
    {
        return $this->user()?->isStudent() ?? false;
    }

    /**
     * Check if the current user can manage the resource
     * (either admin or owns the resource)
     */
    public function canManage(?int $ownerId): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        return $this->userId() === $ownerId;
    }

    /**
     * Check if user is authenticated
     */
    public function check(): bool
    {
        return Auth::check();
    }
}
