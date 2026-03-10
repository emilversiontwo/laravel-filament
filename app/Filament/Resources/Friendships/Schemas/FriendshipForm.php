<?php

namespace App\Filament\Resources\Friendships\Schemas;

use App\Enums\Friendship\FriendshipStatusEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class FriendshipForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Select::make('friend_user_id')
                    ->relationship('friendUser', 'name')
                    ->required(),
                Select::make('status')
                    ->options(FriendshipStatusEnum::getValues())
                    ->required(),
            ]);
    }
}
