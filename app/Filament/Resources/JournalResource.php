<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JournalResource\Pages;
use App\Filament\Resources\JournalResource\RelationManagers;
use App\Models\Journal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\Layout\Split;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Checkbox;

class JournalResource extends Resource
{
    protected static ?string $model = Journal::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'default' => 1,
                ])
                    ->schema([
                        TextInput::make('name')
                            ->label('Journal Name'),
                        TextInput::make('oai_path')
                            ->label('OAI Path'),
                        TextInput::make('max_list_record')
                            ->numeric()
                            ->label('Maximum List Record'),
                        Checkbox::make('bpress')
                            ->label('BPress')
                            ->inline(),
                        Checkbox::make('eprint')
                            ->label('EPrint')
                            ->inline(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Journal Name'),
                TextColumn::make('oai_path')
                    ->label('OAI Path'),
                TextColumn::make('max_list_record')
                    ->label('Maximum List Record'),
                CheckboxColumn::make('bpress')
                    ->label('BPress'),
                CheckboxColumn::make('eprint')
                    ->label('EPrint'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJournals::route('/'),
            // 'create' => Pages\CreateJournal::route('/create'),
            // 'edit' => Pages\EditJournal::route('/{record}/edit'),
        ];
    }
}
