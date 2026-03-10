<?php

namespace App\Filament\Resources\Chats\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ChatForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('type')
                    ->required(),
                TextInput::make('title'),
                TextInput::make('settings'),
            ]);
    }
}
