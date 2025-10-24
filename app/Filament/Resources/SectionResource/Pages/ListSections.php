<?php

namespace App\Filament\Resources\SectionResource\Pages;

use App\Filament\Resources\SectionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListSections extends ListRecords
{
    protected static string $resource = SectionResource::class;

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
        return [
            Actions\CreateAction::make(),
        ];
    }
}
