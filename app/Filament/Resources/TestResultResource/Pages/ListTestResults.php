<?php

namespace App\Filament\Resources\TestResultResource\Pages;

use App\Filament\Resources\TestResultResource;
use App\Filament\Traits\HasInstructorAccess;
use Filament\Resources\Pages\ListRecords;

class ListTestResults extends ListRecords
{
    use HasInstructorAccess;

    protected static string $resource = TestResultResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
