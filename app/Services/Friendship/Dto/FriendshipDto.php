<?php

namespace App\Services\Friendship\Dto;

use App\Helpers\Dto\Dto;

class FriendshipDto extends Dto
{
    public int $user_id;

    public int $friendship_id;
}
