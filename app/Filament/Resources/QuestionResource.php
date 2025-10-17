<?php

namespace App\Filament\Resources;

use App\Enums\QuestionTypeEnum;
use App\Filament\Resources\QuestionResource\Pages;
use App\Models\Question;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class QuestionResource extends Resource
{
    protected static ?string $model = Question::class;
    protected static ?string $navigationIcon = 'heroicon-o-question-mark-circle';
    protected static ?string $navigationGroup = 'Тести';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('test_id')->relationship('test','title')->required(),
            Textarea::make('question_text')->required(),
            Select::make('question_type')
                ->options(
                    collect(QuestionTypeEnum::cases())
                        ->mapWithKeys(fn($case) => [$case->value => $case->name])
                        ->toArray()
                )
                ->label('Question Type')
                ->required(),
            FileUpload::make('image_path')
                ->image()
                ->directory('questions/images')
                ->label('Question Image'),
            FileUpload::make('video_path')
                ->directory('questions/videos')
                ->label('Question Video'),
            FileUpload::make('audio_path')
                ->directory('questions/audios'),
            Hidden::make('user_id')->default(auth()->id()),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id'),
            TextColumn::make('question_text')->limit(60),
            TextColumn::make('test.title')->label('Tests'),
        ])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestions::route('/'),
            'create' => Pages\CreateQuestion::route('/create'),
            'edit' => Pages\EditQuestion::route('/{record}/edit'),
        ];
    }
}
