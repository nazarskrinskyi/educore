<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AnswerResource\Pages;
use App\Models\Answer;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class AnswerResource extends Resource
{
    protected static ?string $model = Answer::class;
    protected static ?string $navigationIcon = 'heroicon-o-check-badge';
    protected static ?string $navigationGroup = 'Тести';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('question_id')->relationship('question','question_text')->searchable(),
            Textarea::make('answer_text')->required(),
            FileUpload::make('answer_image')->directory('answers/images')->image()->label('Answer Image'),
            FileUpload::make('answer_video')->directory('answers/videos')->label('Answer Video'),
            FileUpload::make('answer_audio')->directory('answers/audios')->label('Answer Audio'),
            Toggle::make('is_correct')->label('Is Correct'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id'),
            TextColumn::make('answer_text')->limit(80),
            TextColumn::make('question.question_text')->label('Question')->limit(60),
            TextColumn::make('is_correct')->label('Correct'),
        ])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAnswers::route('/'),
            'create' => Pages\CreateAnswer::route('/create'),
            'edit' => Pages\EditAnswer::route('/{record}/edit'),
        ];
    }
}
