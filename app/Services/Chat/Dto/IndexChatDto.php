<?php

namespace App\Services\Chat\Dto;

use App\Helpers\Dto\Dto;

class IndexChatDto extends Dto
{
    public ?string $type = null;
    public ?string $title = null;
    public ?int $per_page = null;
    public ?int $page = null;

    public int $user_id;
}
