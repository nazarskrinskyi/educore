<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListTags extends ListRecords
{
    protected static string $resource = TagResource::class;

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
