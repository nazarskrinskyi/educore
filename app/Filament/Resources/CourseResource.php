<?php

namespace App\Filament\Resources;

use App\Enums\CourseLevelEnum;
use App\Filament\Resources\CourseResource\Pages;
use App\Models\Course;
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
use Pelmered\FilamentMoneyField\Forms\Components\MoneyInput;

class CourseResource extends Resource
{
    protected static ?string $model = Course::class;
    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';
    protected static ?string $navigationGroup = 'Курси та контент';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('title')
                ->required(),

            TextInput::make('slug')
                ->required(),

            Select::make('category_id')
                ->relationship('category', 'name')
                ->searchable(),

            Select::make('instructor_id')
                ->relationship('instructor', 'name')
                ->searchable(),

            Textarea::make('description'),

            MoneyInput::make('price'),

            Select::make('tags')
                ->multiple()
                ->relationship('tags', 'name')
                ->preload()
                ->searchable(),

            FileUpload::make('image_path')
                ->image()
                ->directory('courses/images')
                ->label('Course Image'),

            FileUpload::make('video_path')
                ->directory('courses/videos')
                ->label('Course Video'),

            Toggle::make('is_published')
                ->label('Published'),

            Toggle::make('is_free')
                ->label('Free Course'),

            Select::make('level')
                ->options(
                    collect(CourseLevelEnum::cases())
                        ->mapWithKeys(fn($case) => [$case->value => $case->name])
                        ->toArray()
                )
                ->label('Difficulty Level')
                ->required(),

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
            TextColumn::make('id')->sortable(),
            TextColumn::make('title')->searchable()->limit(30),
            TextColumn::make('category.name')->label('Category'),
            TextColumn::make('instructor.name')->label('Instructor'),
            TextColumn::make('price')->money('usd'),
            TextColumn::make('created_at')->dateTime(),
        ])->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ])->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourses::route('/'),
            'create' => Pages\CreateCourse::route('/create'),
            'edit' => Pages\EditCourse::route('/{record}/edit'),
        ];
    }
}
