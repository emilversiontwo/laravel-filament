<?php

namespace App\Enums\Friendship;

enum FriendshipStatusEnum: string
{
    case PENDING = 'pending';

    case ACCEPTED = 'accepted';

    case BLOCKED = 'blocked';

    public static function tryFromString(string $value): self
    {
        return match ($value) {
            self::PENDING->getValue() => self::PENDING,
            self::ACCEPTED->getValue() => self::ACCEPTED,
            self::BLOCKED->getValue() => self::BLOCKED,
        };
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public static function getValues(): array
    {
        return [
            self::PENDING->value => self::PENDING->name,
            self::ACCEPTED->value => self::ACCEPTED->name,
            self::BLOCKED->value => self::BLOCKED->name,
        ];
    }
}
