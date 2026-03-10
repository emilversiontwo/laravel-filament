<?php

namespace App\Services\Message\Dto;

use App\Helpers\Dto\Dto;

class UpdateMessageDto extends MessageDto
{
    public string $body = '';
}
