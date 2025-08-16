<?php

namespace App\Enums;

enum QuestionTypeEnum: int
{
    case MultipleChoice = 1;
    case OpenEnded = 2;
    case TrueFalse = 3;
    case ShortAnswer = 4;
    case MultipleChoiceAndShortAnswer = 5;
    case TrueFalseAndShortAnswer = 6;
    case MultipleChoiceAndTrueFalse = 7;

    public function getValue(): int
    {
        return $this->value;
    }

    public static function getValues(): array
    {
        return array_map(fn($role) => $role->value, self::cases());
    }
}
