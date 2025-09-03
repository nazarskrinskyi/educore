<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LessonResource\Pages;
use App\Models\Lesson;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class LessonResource extends Resource
{
    protected static ?string $model = Lesson::class;
    protected static ?string $navigationIcon = 'heroicon-o-book-open';
    protected static ?string $navigationGroup = 'Курси та контент';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('section_id')->relationship('section','title')->required(),
            TextInput::make('title')->required(),
            TextInput::make('slug')->required(),
            Textarea::make('content'),
            FileUpload::make('video_path')->directory('lessons/videos')->maxSize(102400)->required(),
            FileUpload::make('image_path')->directory('lessons/images')->image()->required(),
            Toggle::make('is_published'),
            TextInput::make('views')
                ->numeric()
                ->default(0)
                ->disabled()
                ->label('Views'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id'),
            TextColumn::make('title')->searchable(),
        ])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLessons::route('/'),
            'create' => Pages\CreateLesson::route('/create'),
            'edit' => Pages\EditLesson::route('/{record}/edit'),
        ];
    }
}
