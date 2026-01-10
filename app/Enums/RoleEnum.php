<?php

declare(strict_types=1);

namespace App\Enums;

enum RoleEnum: string
{
    case STUDENT = 'student';
    case INSTRUCTOR = 'instructor';
    case ADMIN = 'admin';

    /**
     * Get the enum value (for backward compatibility)
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Get all enum values as an array
     */
    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get human-readable label
     */
    public function label(): string
    {
        return match ($this) {
            self::STUDENT => 'Student',
            self::INSTRUCTOR => 'Instructor',
            self::ADMIN => 'Administrator',
        };
    }

    /**
     * Check if role has admin privileges
     */
    public function isAdmin(): bool
    {
        return $this === self::ADMIN;
    }

    /**
     * Check if role has instructor privileges
     */
    public function isInstructor(): bool
    {
        return $this === self::INSTRUCTOR;
    }
}

