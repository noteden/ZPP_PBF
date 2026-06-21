<?php

namespace App\Filament\Resources\Profiles;

use App\Models\Profile;
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

class ProfileResource extends Resource
{
    protected static ?string $model = Profile::class;

    protected static ?string $slug = 'profiles';

    protected static ?string $modelLabel = 'Profil';

    protected static ?string $pluralModelLabel = 'Profile';


    protected static string | \UnitEnum | null $navigationGroup = 'Administracja';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                TextInput::make('age')
                    ->required()
                    ->integer(),

                TextInput::make('user_id')
                    ->required()
                    ->integer(),

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
                    ->label('Nazwa')
                    ->searchable(),
                TextColumn::make('age')
                    ->label('Wiek'),
                TextColumn::make('user.name')
                    ->label('Użytkownik')
                    ->default('—'),
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
            'index' => Pages\ListProfiles::route('/'),
            'create' => Pages\CreateProfile::route('/create'),
            'edit' => Pages\EditProfile::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
