<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JournalResource\Pages;
use App\Filament\Resources\JournalResource\RelationManagers;
use App\Models\Journal;
use App\Models\ArticleRepository;
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

// crawler
use App\Observers\ArticleRepositoryObserver;
use Spatie\Crawler\Crawler;

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
                        Checkbox::make('dspace')
                            ->label('Dspace')
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
                    ->label('OAI Path')
                    ->limit(50),
                TextColumn::make('max_list_record')
                    ->label('Maximum List Record'),
                CheckboxColumn::make('bpress')
                    ->label('BPress'),
                CheckboxColumn::make('dspace')
                    ->label('Dspace'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\Action::make('recrawl')
                    ->color('gray')
                    ->icon('heroicon-o-arrow-path')
                    ->action(function (Journal $record) {
                        $path = $record->oai_path;
                        $limit = $record->max_list_record;

                        $observer = new ArticleRepositoryObserver();
                        $observer->setLimit($limit);
                        
                        $agent = request()->header('User-Agent');

                        Crawler::create()
                            ->setCrawlObserver($observer)
                            ->setUserAgent($agent)
                            ->startCrawling($path);

                        // $xml = $observer->results;
                        foreach ($observer->results as $data) {
                            $identifiers = $data->identifier;
                            $url = is_string($identifiers)
                                ? $identifiers
                                : current(array_filter($identifiers, fn($v) => is_string($v) && str_starts_with($v, 'https:')));

                            // Journal::createOrUpdate([

                            // ]);
                        }

                        \Filament\Notifications\Notification::make()
                            ->title('Data crawled successfully')
                            ->body("Total data crawled: ".count($observer->results))
                            ->success()
                            ->send();
                    }),
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
