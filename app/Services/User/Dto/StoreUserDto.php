<?php
declare(strict_types=1);

namespace App\Services\User\Dto;

class StoreUserDto extends UserIdDto
{
    public string $email;

    public string $password;

    public string $name = "";

    public ?string $nickname = null;

    public string $gender;

    public string $birthday;

    public string $best_friend_name;

    public int $user_type_id;
}
