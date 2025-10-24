<?php

namespace App\Filament\Resources\OrderItemResource\Pages;

use App\Filament\Resources\OrderItemResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListOrderItems extends ListRecords
{
    protected static string $resource = OrderItemResource::class;

    protected function getTableQuery(): Builder
    {
        if (auth()->user()->isAdmin()) {
            return parent::getTableQuery();
        }

        return parent::getTableQuery()->whereHas('section.course', function ($query) {
            $query->where('user_id', auth()->id());
        });
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
