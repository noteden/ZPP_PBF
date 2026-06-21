<?php

namespace App\Filament\Resources\Charakters;

use App\Models\Charakter;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CharakterResource extends Resource
{
    protected static ?string $model = Charakter::class;

    protected static ?string $slug = 'charakters';

    protected static ?string $modelLabel = 'Postać';

    protected static ?string $pluralModelLabel = 'Postacie';


    protected static string | \UnitEnum | null $navigationGroup = 'Mechanika gry';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                TextInput::make('age')
                    ->required(),

                Select::make('origin')
                    ->label('POCHODZENIE')
                    ->options([
                        'Northern Kingdoms' => 'Northern Kingdoms',
                        'Southern Empires' => 'Southern Empires',
                        'Eastern Steppes' => 'Eastern Steppes',
                        'Western Isles' => 'Western Isles',
                        'Ancient Ruins' => 'Ancient Ruins',
                        'Capital City' => 'Capital City',
                        'Wild Frontier' => 'Wild Frontier',
                    ])
                    ->searchable()
                    ->required(),

                Select::make('race')
                    ->label('RASA')
                    ->options([
                        'Human' => 'Human',
                        'Elf' => 'Elf',
                        'Dwarf' => 'Dwarf',
                        'Halfling' => 'Halfling',
                        'Orc' => 'Orc',
                        'Tiefling' => 'Tiefling',
                        'Dragonborn' => 'Dragonborn',
                        'Gnome' => 'Gnome',
                    ])
                    ->searchable()
                    ->required(),

                Select::make('eyes')
                    ->label('OCZY')
                    ->options([
                        'Amber' => 'Amber',
                        'Blue' => 'Blue',
                        'Brown' => 'Brown',
                        'Gray' => 'Gray',
                        'Green' => 'Green',
                        'Hazel' => 'Hazel',
                        'Red' => 'Red',
                        'Violet' => 'Violet',
                        'Heterochromia' => 'Heterochromia',
                    ])
                    ->searchable()
                    ->required(),

                TextInput::make('hair')
                    ->label('WŁOSY')
                    ->required(),

                TextInput::make('biography')
                    ->label('BIOGRAFIA')
                    ->required(),

                Select::make('user_id')
                    ->label('UŻYTKOWNIK')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

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
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->emptyStateHeading('Brak postaci')
            ->emptyStateDescription('Stwórz pierwszą postać, aby rozpocząć przygodę.')
            ->emptyStateActions([
                \Filament\Actions\CreateAction::make()
                    ->label('Stwórz pierwszą postać'),
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
            'index' => Pages\ListCharakters::route('/'),
            'create' => Pages\CreateCharakter::route('/create'),
            'edit' => Pages\EditCharakter::route('/{record}/edit'),
        ];
    }

    /**
     * @return Builder<Charakter>
     */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['user']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'user.name'];
    }

    /**
     * @param Charakter $record
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->user) {
            $details['User'] = $record->user->name;
        }

        return $details;
    }
}
