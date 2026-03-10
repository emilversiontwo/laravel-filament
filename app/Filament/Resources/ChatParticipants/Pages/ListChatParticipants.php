<?php

namespace App\Filament\Resources\ChatParticipants\Pages;

use App\Filament\Resources\ChatParticipants\ChatParticipantResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListChatParticipants extends ListRecords
{
    protected static string $resource = ChatParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
