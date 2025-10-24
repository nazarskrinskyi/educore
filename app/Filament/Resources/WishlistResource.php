<?php

namespace App\Filament\Resources;

use App\Filament\Resources\WishlistResource\Pages;
use App\Models\Wishlist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class WishlistResource extends Resource
{
    protected static ?string $model = Wishlist::class;
    protected static ?string $navigationIcon = 'heroicon-o-heart';
    protected static ?string $navigationGroup = 'Курси та контент';

    public static function canAccess(): bool
    {
        return auth()->user()->isAdmin();
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('user.name')->label('User'),
            TextColumn::make('course.title')->label('Course'),
            TextColumn::make('created_at')->dateTime(),
        ])->actions([Tables\Actions\DeleteAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListWishlists::route('/'),
        ];
    }
}
