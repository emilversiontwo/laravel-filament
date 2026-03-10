<?php

namespace App\Services\ChatParticipant\Dto;

use App\Helpers\Dto\Dto;

class StoreChatParticipantDto extends Dto
{
    public int $chat_id;

    public int $user_id;

    public string $role;
}
