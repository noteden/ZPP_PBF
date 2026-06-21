<?php

namespace App\Filament\Resources\PostReports;

use App\Models\PostReport;
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

class PostReportResource extends Resource
{
    protected static ?string $model = PostReport::class;

    protected static ?string $slug = 'post-reports';

    protected static ?string $modelLabel = 'Zgłoszenie';

    protected static ?string $pluralModelLabel = 'Zgłoszenia';

    protected static string | \UnitEnum | null $navigationGroup = 'Forum';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Zgłaszający')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->required(),

                TextInput::make('post_id')
                    ->label('ID posta')
                    ->required()
                    ->integer(),

                TextInput::make('reason')
                    ->label('Powód')
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
                TextColumn::make('user.name')
                    ->label('Zgłaszający')
                    ->searchable(),
                TextColumn::make('reason')
                    ->label('Powód')
                    ->limit(50),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),
                TextColumn::make('created_at')
                    ->label('Zgłoszono')
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
            'index' => Pages\ListPostReports::route('/'),
            'create' => Pages\CreatePostReport::route('/create'),
            'edit' => Pages\EditPostReport::route('/{record}/edit'),
        ];
    }

    /**
     * @return Builder<PostReport>
     */
    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['user']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['user.name'];
    }

    /**
     * @param PostReport $record
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
