<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CourseUserResource\Pages;
use App\Models\CourseUser;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class CourseUserResource extends Resource
{
    protected static ?string $model = CourseUser::class;
    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Курси та контент';

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('course.title')->label('Course'),
            TextColumn::make('user.name')->label('User'),
            TextColumn::make('progress_percent')->suffix('%'),
            TextColumn::make('enrolled_at')->dateTime(),
        ])->actions([Tables\Actions\EditAction::make(), Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCourseUsers::route('/'),
        ];
    }
}
