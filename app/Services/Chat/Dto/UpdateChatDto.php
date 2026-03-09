<?php

namespace App\Services\Chat\Dto;

use App\Helpers\Dto\Dto;

class UpdateChatDto extends ChatDto
{
    public ?string $title = null;
}
