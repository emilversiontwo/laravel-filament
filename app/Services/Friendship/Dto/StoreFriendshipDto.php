<?php

namespace App\Services\Friendship\Dto;

use App\Helpers\Dto\Dto;

class StoreFriendshipDto extends Dto
{
    public int $user_id;

    public int $friend_user_id;
}
