<?php

namespace App\Enums\Friendship;

enum FriendshipTypeSortEnum: string
{
    case MY = 'my';

    case OTHER = 'other';

    public static function tryFromString(string $value): self
    {
        return match ($value) {
            self::MY->getValue() => self::MY,
            self::OTHER->getValue() => self::OTHER,
        };
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
