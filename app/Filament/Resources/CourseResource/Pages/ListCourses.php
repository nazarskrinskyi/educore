<?php

namespace App\Filament\Resources\CourseResource\Pages;

use App\Filament\Resources\CourseResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListCourses extends ListRecords
{
    protected static string $resource = CourseResource::class;

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
