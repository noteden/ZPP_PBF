<?php

namespace App\Filament\Resources\Documents;

use App\Models\Documents;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class DocumentsResource extends Resource
{
    protected static ?string $model = Documents::class;

    protected static ?string $slug = 'documents';

    protected static ?string $modelLabel = 'Dokument';

    protected static ?string $pluralModelLabel = 'Dokumenty';

    protected static string | \UnitEnum | null $navigationGroup = 'Administracja';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),

                MarkdownEditor::make('content')
                    ->required(),

                Select::make('category')
                    ->label('Kategoria')
                    ->options([
                        'lore'      => 'Lore / fabuła',
                        'regulamin' => 'Regulamin',
                        'mechanika' => 'Mechanika (wpływ wydarzeń)',
                        'mapa'      => 'Mapa',
                        'inne'      => 'Inne',
                    ])
                    ->default('lore'),

                FileUpload::make('file_path')
                    ->label('Załącznik (mapa / PDF / grafika)')
                    ->directory('documents')
                    ->acceptedFileTypes(['application/pdf', 'image/png', 'image/jpeg', 'image/webp'])
                    ->maxSize(10240),

                TextInput::make('published_add')
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
                    ->label('Nazwa')
                    ->searchable(),
                TextColumn::make('category')
                    ->label('Kategoria')
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('Dodano')
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
            'index' => Pages\ListDocuments::route('/'),
            'create' => Pages\CreateDocuments::route('/create'),
            'edit' => Pages\EditDocuments::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
