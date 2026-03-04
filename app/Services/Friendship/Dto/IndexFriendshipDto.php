<?php

namespace App\Services\Friendship\Dto;

use App\Helpers\Dto\Dto;

class IndexFriendshipDto extends Dto
{
    public ?string $type_sort;

    public int $user_id;

    public int $per_page = 10;

    public int $page = 1;
}
