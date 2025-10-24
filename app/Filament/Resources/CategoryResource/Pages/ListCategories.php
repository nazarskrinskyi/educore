<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;

    protected function getTableQuery(): Builder
    {
        if (auth()->user()->isAdmin()) {
            return parent::getTableQuery();
        }

        return parent::getTableQuery()->where('user_id', auth()->id());
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
