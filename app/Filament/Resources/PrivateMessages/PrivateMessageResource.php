<?php

namespace App\Filament\Resources\PrivateMessages;

use App\Models\PrivateMessage;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PrivateMessageResource extends Resource
{
    protected static ?string $model = PrivateMessage::class;

    protected static ?string $slug = 'private-messages';

    protected static ?string $modelLabel = 'Wiadomość prywatna';

    protected static ?string $pluralModelLabel = 'Wiadomości prywatne';


    protected static string | \UnitEnum | null $navigationGroup = 'Komunikacja';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('sender_user_id')
                    ->relationship('senderUser', 'name')
                    ->searchable()
                    ->required(),

                Select::make('receiver_user_id')
                    ->relationship('receiverUser', 'name')
                    ->searchable()
                    ->required(),

                MarkdownEditor::make('content')
                    ->required(),

                Checkbox::make('is_read'),

                TextEntry::make('created_at')
                    ->label('Data utworzenia')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->label('Data modyfikacji')
                    ->dateTime(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('senderUser.name')
                    ->searchable(),
                TextColumn::make('receiverUser.name')
                    ->searchable(),
                ToggleColumn::make('is_read')
                    ->label('Przeczytane'),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPrivateMessages::route('/'),
            'create' => Pages\CreatePrivateMessage::route('/create'),
            'edit' => Pages\EditPrivateMessage::route('/{record}/edit'),
        ];
    }

    /**
     * @return Builder<PrivateMessage>
     */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['senderUser', 'receiverUser']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['senderUser.name', 'receiverUser.name'];
    }

    /**
     * @param PrivateMessage $record
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->senderUser) {
            $details['SenderUser'] = $record->senderUser->name;
        }

        if ($record->receiverUser) {
            $details['ReceiverUser'] = $record->receiverUser->name;
        }

        return $details;
    }
}
