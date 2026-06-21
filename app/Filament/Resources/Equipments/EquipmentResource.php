<?php

namespace App\Filament\Resources\Equipments;

use App\Models\Equipment;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;

    protected static ?string $slug = 'equipment';


    protected static ?string $modelLabel = 'Ekwipunek';

    protected static ?string $pluralModelLabel = 'Ekwipunek';

    protected static string | \UnitEnum | null $navigationGroup = 'Mechanika gry';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                TextInput::make('description')
                    ->required(),

                TextInput::make('weight')
                    ->required()
                    ->numeric(),

                TextInput::make('type')
                    ->required(),

                \Filament\Forms\Components\KeyValue::make('statistic')
                    ->label('STATYSTYKI')
                    ->required()
                    ->columnSpanFull(),

                TextEntry::make('created_at')
                    ->label('Data utworzenia')
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
                TextColumn::make('type')
                    ->label('Typ')
                    ->searchable(),
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
            'index' => Pages\ListEquipments::route('/'),
            'create' => Pages\CreateEquipment::route('/create'),
            'edit' => Pages\EditEquipment::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
