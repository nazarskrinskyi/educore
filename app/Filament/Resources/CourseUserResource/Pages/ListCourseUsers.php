<?php

namespace App\Filament\Resources\CourseUserResource\Pages;

use App\Filament\Resources\CourseUserResource;
use App\Filament\Traits\HasInstructorAccessViaRelation;
use Filament\Resources\Pages\ListRecords;

class ListCourseUsers extends ListRecords
{
    use HasInstructorAccessViaRelation;

    protected static string $resource = CourseUserResource::class;

    protected function getInstructorRelationship(): string
    {
        return 'course';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
