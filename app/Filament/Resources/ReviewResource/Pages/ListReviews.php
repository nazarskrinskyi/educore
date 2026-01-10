<?php

namespace App\Filament\Resources\ReviewResource\Pages;

use App\Filament\Resources\ReviewResource;
use App\Filament\Traits\HasInstructorAccessViaRelation;
use Filament\Resources\Pages\ListRecords;

class ListReviews extends ListRecords
{
    use HasInstructorAccessViaRelation;

    protected static string $resource = ReviewResource::class;

    protected function getInstructorRelationship(): string
    {
        return 'course';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
