<?php

namespace App\Filament\Resources\SectionResource\Pages;

use App\Filament\Resources\SectionResource;
use App\Filament\Traits\HasInstructorAccessViaRelation;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSections extends ListRecords
{
    use HasInstructorAccessViaRelation;

    protected static string $resource = SectionResource::class;

    protected function getInstructorRelationship(): string
    {
        return 'course';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
