<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserBadgeResource\Pages;
use App\Models\UserBadge;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class UserBadgeResource extends Resource
{
    protected static ?string $model = UserBadge::class;
    protected static ?string $navigationIcon = 'heroicon-o-trophy';
    protected static ?string $navigationGroup = 'Гейміфікація';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('user_id')->relationship('user','name')->required(),
            Select::make('badge_id')->relationship('badge','name')->required(),
            DateTimePicker::make('awarded_at'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('user.name')->label('User'),
            TextColumn::make('badge.name')->label('Badge'),
            TextColumn::make('awarded_at')->dateTime(),
        ])->actions([Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserBadges::route('/'),
            'create' => Pages\CreateUserBadge::route('/create'),
            'edit' => Pages\EditUserBadge::route('/{record}/edit'),
        ];
    }
}
