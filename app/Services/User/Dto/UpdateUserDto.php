<?php
declare(strict_types=1);

namespace App\Services\User\Dto;

class UpdateUserDto extends UserIdDto
{
    public ?string $name = null;

    public ?string $email = null;

    public ?string $password = null;

    public ?string $nickname = null;

    public ?string $gender = null;

    public ?string $birthday = null;

    public ?string $best_friend_name = null;

    public ?int $user_type_id = null;
}
