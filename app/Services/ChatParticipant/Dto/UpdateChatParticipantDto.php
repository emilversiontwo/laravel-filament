<?php

namespace App\Services\ChatParticipant\Dto;

use App\Helpers\Dto\Dto;

class UpdateChatParticipantDto extends ChatParticipantDto
{
    public string $role;
}
