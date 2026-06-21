<?php

namespace App\Filament\Resources\Skills;

use App\Models\Skill;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SkillResource extends Resource
{
    protected static ?string $model = Skill::class;

    protected static ?string $slug = 'skills';


    protected static string | \UnitEnum | null $navigationGroup = 'Game Mechanics';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                Checkbox::make('accepted'),

                TextInput::make('description')
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
                    ['label' => 'SKILL NAME', 'field' => 'name', 'width' => 'col-span-12 md:col-span-5', 'icon' => 'bolt'],
                    ['label' => 'DESCRIPTION', 'field' => 'description', 'width' => 'col-span-12 md:col-span-4'],
                    ['label' => 'ACCEPTED', 'field' => 'accepted', 'width' => 'col-span-12 md:col-span-3', 'type' => 'toggle'],
                ]
            ]))
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
                TextColumn::make('description')
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
            'index' => Pages\ListSkills::route('/'),
            'create' => Pages\CreateSkill::route('/create'),
            'edit' => Pages\EditSkill::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
