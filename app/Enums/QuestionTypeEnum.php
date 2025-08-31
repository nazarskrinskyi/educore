<?php

namespace App\Enums;

enum QuestionTypeEnum: int
{
    case MultipleChoice = 1;
    case MultipleAnswer = 2;
    case TrueFalse = 3;
    case ShortAnswer = 4;

    public function getValue(): int
    {
        return $this->value;
    }

    public static function getValues(): array
    {
        return array_map(fn($role) => $role->value, self::cases());
    }
}
