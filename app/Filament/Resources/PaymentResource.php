<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Фінанси';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('user_id')->relationship('user','name')->required(),
            Select::make('course_id')->relationship('course','title')->required(),
            TextInput::make('amount')->numeric()->required(),
            TextInput::make('status')->required(),
            TextInput::make('payment_method'),
            TextInput::make('transaction_id'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('id'),
            TextColumn::make('user.name')->label('User'),
            TextColumn::make('course.title')->label('Course'),
            TextColumn::make('amount')->money('usd'),
            TextColumn::make('status')->sortable(),
            TextColumn::make('created_at')->dateTime(),
        ])->actions([Tables\Actions\EditAction::make()]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
            'create' => Pages\CreatePayment::route('/create'),
            'edit' => Pages\EditPayment::route('/{record}/edit'),
        ];
    }
}
