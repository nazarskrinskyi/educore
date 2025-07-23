<?php

namespace App\Enums;

enum RoleEnum: string
{
    case STUDENT = 'student';
    case INSTRUCTOR = 'instructor';
    case ADMIN = 'admin';
    case MODERATOR = 'moderator';

    public static function getValues(): array
    {
        return [
            self::STUDENT,
            self::INSTRUCTOR,
            self::ADMIN,
            self::MODERATOR
        ];
    }
    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}

