<?php

namespace App\Services\Message\Dto;

use App\Helpers\Dto\Dto;

class StoreMessageDto extends Dto
{
    public ?int $parent_id = null;

    public string $body;

    public int $chat_id;

    public int $user_id;
}
