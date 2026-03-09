<?php

namespace App\Enums\ChatParticipant;

enum ChatParticipantRoleEnum: string
{
    case ADMIN = 'admin';

    case MEMBER = 'member';

    public static function tryFromString(string $value): self
    {
        return match ($value) {
            self::ADMIN->getValue() => self::ADMIN,
            self::MEMBER->getValue() => self::MEMBER,
        };
    }

    public function getValue(): string
    {
        return $this->value;
    }
}
