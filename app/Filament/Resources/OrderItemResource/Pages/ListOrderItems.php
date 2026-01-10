<?php

namespace App\Filament\Resources\OrderItemResource\Pages;

use App\Filament\Resources\OrderItemResource;
use App\Filament\Traits\HasInstructorAccessViaRelation;
use Filament\Resources\Pages\ListRecords;

class ListOrderItems extends ListRecords
{
    use HasInstructorAccessViaRelation;

    protected static string $resource = OrderItemResource::class;

    protected function getInstructorRelationship(): string
    {
        return 'course';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
