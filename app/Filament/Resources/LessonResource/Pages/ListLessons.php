<?php

namespace App\Filament\Resources\LessonResource\Pages;

use App\Filament\Resources\LessonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListLessons extends ListRecords
{
    protected static string $resource = LessonResource::class;

    protected function getTableQuery(): Builder
    {
        if (auth()->user()->isAdmin()) {
            return parent::getTableQuery();
        }

        return parent::getTableQuery()->whereHas('section.course', function ($query) {
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
