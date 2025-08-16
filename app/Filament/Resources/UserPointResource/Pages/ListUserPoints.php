<?php

namespace App\Filament\Resources\UserPointResource\Pages;

use App\Filament\Resources\UserPointResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUserPoints extends ListRecords
{
    protected static string $resource = UserPointResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
