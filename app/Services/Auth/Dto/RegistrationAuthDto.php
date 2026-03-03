<?php
declare(strict_types=1);

namespace App\Services\Auth\Dto;

use App\Helpers\Dto\Dto;

/**
 * name
 * email
 * nickname
 * gender
 * birthday
 * best_friend_name
 * user_type_id
 * password
 */
class RegistrationAuthDto extends Dto
{
    public string $email;

    public string $password;

    public string $name = "";

    public ?string $nickname = null;

    public string $gender;

    public string $birthday;

    public string $best_friend_name;

    public int $user_type_id;

    public string $token_name;
}
