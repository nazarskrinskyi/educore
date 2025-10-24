<?php

namespace App\Enums;

enum RoleEnum: string
{
    case STUDENT = 'student';
    case INSTRUCTOR = 'instructor';
    case ADMIN = 'admin';

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    public static function getValues(): array
    {
        return array_map(fn($role) => $role->value, self::cases());
    }
}

