<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Enums\User\UserGenderEnum;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required(),
                TextInput::make('nickname'),
                Select::make('gender')
                    ->options(UserGenderEnum::getValues())
                    ->required(),
                DatePicker::make('birthday')
                    ->required(),
                TextInput::make('best_friend_name')
                    ->required(),
                Select::make('user_type_id')
                    ->relationship('userType', 'name')
                    ->required(),
                Toggle::make('is_admin')
                    ->required(),
            ]);
    }
}
