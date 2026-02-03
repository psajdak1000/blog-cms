<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Models\Post;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
// Importy komponentów formularza
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Toggle;
// Importy kolumn tabeli i filtrów
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Filters\SelectFilter; // <--- To jest ważne dla filtrów

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                
                // Wybór kategorii (korzysta z relacji, którą zrobiliśmy w modelach)
                Select::make('category_id')
                    ->label('Kategoria')
                    ->relationship('category', 'name')
                    ->required(),

                TextInput::make('slug')
                    ->required()
                    ->maxLength(255),

                // Przełącznik statusu (Opublikowany TAK/NIE)
                Toggle::make('status')
                    ->label('Opublikowany')
                    ->onColor('success')
                    ->offColor('danger')
                    ->default(false),

                // Edytor tekstu (na całą szerokość)
                RichEditor::make('content')
                    ->columnSpanFull()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                
                TextColumn::make('category.name')
                    ->label('Kategoria')
                    ->sortable(),
                
                // Ikona statusu (ptaszek lub krzyżyk)
                IconColumn::make('status')
                    ->boolean()
                    ->label('Opublikowany?'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                // Filtr po Kategorii
                SelectFilter::make('category_id')
                    ->label('Kategoria')
                    ->relationship('category', 'name'),

                // Filtr po Statusie
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'published' => 'Opublikowany',
                        'draft' => 'Szkic',
                    ]),
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
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }
}