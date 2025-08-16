<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserPointResource\Pages;
use App\Models\UserPoint;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class UserPointResource extends Resource
{
    protected static ?string $model = UserPoint::class;
    protected static ?string $navigationIcon = 'heroicon-o-sparkles';
    protected static ?string $navigationGroup = 'Користувачі та доступи';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('user_id')->relationship('user','name')->required(),
            TextInput::make('points')->numeric()->required(),
            TextInput::make('reason'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('user.name')->label('User'),
            TextColumn::make('points')->sortable(),
            TextColumn::make('reason')->limit(50),
            TextColumn::make('created_at')->dateTime(),
        ])->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUserPoints::route('/'),
            'create' => Pages\CreateUserPoint::route('/create'),
            'edit' => Pages\EditUserPoint::route('/{record}/edit'),
        ];
    }
}
