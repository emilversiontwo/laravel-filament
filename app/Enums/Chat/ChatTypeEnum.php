<?php

namespace App\Enums\Chat;

enum ChatTypeEnum: string
{
    case GROUP = 'group';

    case PERSONAL = 'personal';

    public static function tryFromString(string $value): self
    {
        return match ($value) {
            self::GROUP->getValue() => self::GROUP,
            self::PERSONAL->getValue() => self::PERSONAL,
        };
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
