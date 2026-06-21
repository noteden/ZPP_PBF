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

    protected static ?string $modelLabel = 'Character';

    protected static ?string $pluralModelLabel = 'Characters';


    protected static string | \UnitEnum | null $navigationGroup = 'Game Mechanics';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                TextInput::make('age')
                    ->required(),

                Select::make('origin')
                    ->label('ORIGIN')
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
                    ->label('RACE')
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
                    ->label('EYES')
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
                    ->label('HAIR')
                    ->required(),

                TextInput::make('biography')
                    ->label('BIOGRAPHY')
                    ->required(),

                Select::make('user_id')
                    ->label('USER')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

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
            ->content(fn ($records) => view('filament.resources.common.mythic-table', [
                'records' => $records,
                'headers' => [
                    ['label' => 'CHARACTER', 'field' => 'name', 'subfield' => 'race', 'width' => 'col-span-12 md:col-span-5', 'icon' => 'person_book'],
                    ['label' => 'ORIGIN', 'field' => 'origin', 'width' => 'col-span-12 md:col-span-4'],
                    ['label' => 'PLAYER', 'field' => 'user.name', 'width' => 'col-span-12 md:col-span-3'],
                ]
            ]))
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->emptyStateHeading(new \Illuminate\Support\HtmlString('
                <style>.fi-ta-empty-state-icon-bg { display: none !important; }</style>
                <div class="flex flex-col items-center justify-center -mt-8">
                    <img src="/images/cloak-campfire.png" alt="Empty State Illustration" class="w-56 h-auto object-contain mx-auto mb-6 opacity-90 drop-shadow-[0_0_20px_rgba(245,158,11,0.15)]" />
                    <span class="text-xl font-bold dark:text-white">No characters found</span>
                </div>
            '))
            ->emptyStateDescription('Create your first character to begin your adventure.')
            ->emptyStateActions([
                \Filament\Actions\CreateAction::make()
                    ->label('Create your first character'),
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
