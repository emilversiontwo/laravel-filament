<?php
declare(strict_types=1);

namespace App\Enums\User;

enum UserGenderEnum: string
{
    case MALE = 'male';

    case FEMALE = 'female';

    public static function tryFromString(string $value): self
    {
        return match ($value) {
            self::MALE->getValue() => self::MALE,
            self::FEMALE->getValue() => self::FEMALE,
        };
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function oppositeGender(): self
    {
        return match ($this->value) {
            self::MALE->value => self::FEMALE,
            self::FEMALE->value => self::MALE,
        };
    }

    public static function getValues(): array
    {
        return [
            self::MALE->value => self::MALE->name,
            self::FEMALE->value => self::FEMALE->name,
        ];
    }
}
