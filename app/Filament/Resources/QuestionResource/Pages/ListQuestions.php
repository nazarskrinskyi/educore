<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use App\Filament\Resources\QuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListQuestions extends ListRecords
{
    protected static string $resource = QuestionResource::class;

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
