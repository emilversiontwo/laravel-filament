<?php

namespace App\Filament\Resources\ChatParticipants\Pages;

use App\Filament\Resources\ChatParticipants\ChatParticipantResource;
use Filament\Resources\Pages\CreateRecord;

class CreateChatParticipant extends CreateRecord
{
    protected static string $resource = ChatParticipantResource::class;
}
