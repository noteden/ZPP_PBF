<?php

namespace App\Filament\Resources\Posts;

use App\Models\Post;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $slug = 'posts';

    protected static ?string $modelLabel = 'Post';

    protected static ?string $pluralModelLabel = 'Posty';

    protected static string | \UnitEnum | null $navigationGroup = 'Forum';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                MarkdownEditor::make('content')
                    ->label('Treść')
                    ->required(),

                Select::make('thread_id')
                    ->label('Wątek')
                    ->relationship('thread', 'name')
                    ->searchable()
                    ->required(),

                Select::make('user_id')
                    ->label('Użytkownik')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

                Select::make('charakter_id')
                    ->label('POSTAĆ')
                    ->relationship('charakter', 'name')
                    ->searchable()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('content')
                    ->label('Treść')
                    ->searchable(),
                TextColumn::make('thread.name')
                    ->label('Wątek')
                    ->searchable(),
                TextColumn::make('user.name')
                    ->label('Użytkownik')
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    /**
     * @return Builder<Post>
     */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['thread', 'user', 'charakter']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['thread.name', 'user.name', 'charakter.name'];
    }

    /**
     * @param Post $record
     */
    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->thread) {
            $details['Thread'] = $record->thread->name;
        }

        if ($record->user) {
            $details['User'] = $record->user->name;
        }

        if ($record->charakter) {
            $details['Charakter'] = $record->charakter->name;
        }

        return $details;
    }
}
