<?php

namespace App\Filament\Resources\CharakterSheets;

use App\Models\CharakterSheet;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CharakterSheetResource extends Resource
{
    protected static ?string $model = CharakterSheet::class;

    protected static ?string $slug = 'charakter-sheets';


    protected static string | \UnitEnum | null $navigationGroup = 'Game Mechanics';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('charakter_id')
                    ->relationship('charakter', 'name')
                    ->searchable()
                    ->required(),

                \Filament\Forms\Components\KeyValue::make('statistic')
                    ->label('STATISTICS')
                    ->required()
                    ->columnSpanFull(),

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
                TextColumn::make('charakter.name')
                    ->searchable(),
                TextColumn::make('charakter.user.name')
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
            'index' => Pages\ListCharakterSheets::route('/'),
            'create' => Pages\CreateCharakterSheet::route('/create'),
            'edit' => Pages\EditCharakterSheet::route('/{record}/edit'),
        ];
    }

    /**
     * @return Builder<CharakterSheet>
     */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['charakter']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['charakter.name'];
    }

    /**
     * @param CharakterSheet $record
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->charakter) {
            $details['Charakter'] = $record->charakter->name;
        }

        return $details;
    }
}
