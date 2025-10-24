<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderItemResource\Pages;
use App\Models\OrderItem;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderItemResource extends Resource
{
    protected static ?string $model = OrderItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Замовлення';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('order_id')
                    ->relationship('order', 'id')
                    ->required(),
                Select::make('course_id')
                    ->relationship('course', 'title')
                    ->required(),
                TextInput::make('price')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.id'),
                Tables\Columns\TextColumn::make('course.title'),
                Tables\Columns\TextColumn::make('price'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('order_id')
                    ->relationship('order', 'id'),
                Tables\Filters\SelectFilter::make('course_id')
                    ->relationship('course', 'id'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrderItems::route('/'),
        ];
    }
}
