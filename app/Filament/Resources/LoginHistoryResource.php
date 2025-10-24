<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LoginHistoryResource\Pages;
use App\Models\LoginHistory;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class LoginHistoryResource extends Resource
{
    protected static ?string $model = LoginHistory::class;
    protected static ?string $navigationIcon = 'heroicon-o-arrow-right-on-rectangle';
    protected static ?string $navigationGroup = 'Користувачі та доступи';

    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id'),
            TextColumn::make('user.name')->label('User'),
            TextColumn::make('ip_address'),
            TextColumn::make('user_agent')->limit(60),
            TextColumn::make('logged_in_at')->dateTime(),
        ])->actions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLoginHistories::route('/'),
        ];
    }
}
