<?php

namespace App\Filament\Resources\Chats;

use App\Filament\Resources\Chats\Pages\CreateChat;
use App\Filament\Resources\Chats\Pages\EditChat;
use App\Filament\Resources\Chats\Pages\ListChats;
use App\Filament\Resources\Chats\Schemas\ChatForm;
use App\Filament\Resources\Chats\Tables\ChatsTable;
use App\Models\Chat\Chat;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChatResource extends Resource
{
    protected static ?string $model = Chat::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'Chat';

    public static function form(Schema $schema): Schema
    {
        return ChatForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ChatsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListChats::route('/'),
            'create' => CreateChat::route('/create'),
            'edit' => EditChat::route('/{record}/edit'),
        ];
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        return parent::getRecordRouteBindingEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
