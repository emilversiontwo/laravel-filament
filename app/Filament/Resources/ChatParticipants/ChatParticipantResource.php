<?php

namespace App\Filament\Resources\ChatParticipants;

use App\Filament\Resources\ChatParticipants\Pages\CreateChatParticipant;
use App\Filament\Resources\ChatParticipants\Pages\EditChatParticipant;
use App\Filament\Resources\ChatParticipants\Pages\ListChatParticipants;
use App\Filament\Resources\ChatParticipants\Schemas\ChatParticipantForm;
use App\Filament\Resources\ChatParticipants\Tables\ChatParticipantsTable;
use App\Models\Chat\ChatParticipant;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ChatParticipantResource extends Resource
{
    protected static ?string $model = ChatParticipant::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'ChatParticipant';

    public static function form(Schema $schema): Schema
    {
        return ChatParticipantForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ChatParticipantsTable::configure($table);
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
            'index' => ListChatParticipants::route('/'),
            'create' => CreateChatParticipant::route('/create'),
            'edit' => EditChatParticipant::route('/{record}/edit'),
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
