<?php

namespace App\Services\Message\Dto;

use App\Helpers\Dto\Dto;

class IndexMessageDto extends Dto
{
    public ?int $user_id = null;

    public ?string $body = null;

    public int $per_page = 1;

    public int $page = 1;

    public int $chat_id;
}
