<?php

namespace App\Filament\Resources\ChatParticipants\Schemas;

use App\Enums\ChatParticipant\ChatParticipantRoleEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ChatParticipantForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('chat_id')
                    ->relationship('chat', 'title')
                    ->required(),
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('role')
                    ->options(ChatParticipantRoleEnum::getValues())
                    ->required(),
            ]);
    }
}
