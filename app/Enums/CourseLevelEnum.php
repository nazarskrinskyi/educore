<?php

namespace App\Enums;

enum CourseLevelEnum: int
{
    case Beginner = 1;
    case Intermediate = 2;
    case Advanced = 3;

    public function getValue(): int
    {
        return $this->value;
    }

    public static function getValues(): array
    {
        return array_map(fn($role) => $role->value, self::cases());
    }

    public static function getValuesWithNames(): array
    {
        return array_map(fn($role) => ['value' => $role->value, 'name' => $role->name], self::cases());
    }
}
