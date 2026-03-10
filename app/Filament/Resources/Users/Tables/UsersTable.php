<?php

namespace App\Filament\Resources\Users\Tables;

use App\Enums\User\UserGenderEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\Column;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('email')
                    ->label('Email address')
                    ->searchable(),
                TextColumn::make('email_verified_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('nickname')
                    ->searchable(),
                SelectColumn::make('gender')
                    ->enum(UserGenderEnum::class),
                TextColumn::make('birthday')
                    ->date()
                    ->sortable(),
                TextColumn::make('best_friend_name')
                    ->searchable(),
                TextColumn::make('userType.name')
                    ->searchable(),
                IconColumn::make('is_admin')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('userType.name')
                ->relationship('userType', 'name')
                ->searchable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
