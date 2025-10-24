<?php

namespace App\Filament\Resources\ReviewResource\Pages;

use App\Filament\Resources\ReviewResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListReviews extends ListRecords
{
    protected static string $resource = ReviewResource::class;

    protected function getTableQuery(): Builder
    {
        if (auth()->user()->isAdmin()) {
            return parent::getTableQuery();
        }

        return parent::getTableQuery()->whereHas('course', function ($query) {
            $query->where('user_id', auth()->id());
        });
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
