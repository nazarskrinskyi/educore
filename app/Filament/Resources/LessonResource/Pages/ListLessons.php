<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use App\Filament\Traits\HasInstructorAccessViaRelation;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLessons extends ListRecords
{
    use HasInstructorAccessViaRelation;

    protected static string $resource = LessonResource::class;

    protected function getInstructorRelationship(): string
    {
        return 'section.course';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
