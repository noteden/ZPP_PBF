<?php

namespace App\Filament\Resources\Missions;

use App\Models\Mission;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class MissionResource extends Resource
{
    protected static ?string $model = Mission::class;

    protected static ?string $slug = 'missions';


    protected static string | \UnitEnum | null $navigationGroup = 'Gameplay';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                MarkdownEditor::make('description')
                    ->required(),

                Select::make('status')
                    ->label('Status werdyktu')
                    ->options([
                        'proposed' => 'Zgłoszona',
                        'approved' => 'Zatwierdzona',
                        'rejected' => 'Odrzucona',
                    ])
                    ->default('proposed'),

                Select::make('proposed_by')
                    ->label('Zgłaszający')
                    ->relationship('proposer', 'name')
                    ->searchable(),

                TextEntry::make('created_at')
                    ->label('Created Date')
                    ->dateTime(),

                TextEntry::make('updated_at')
                    ->label('Last Modified Date')
                    ->dateTime(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nazwa')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('proposer.name')
                    ->label('Zgłaszający')
                    ->default('—'),
                TextColumn::make('created_at')
                    ->label('Utworzono')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListMissions::route('/'),
            'create' => Pages\CreateMission::route('/create'),
            'edit' => Pages\EditMission::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
