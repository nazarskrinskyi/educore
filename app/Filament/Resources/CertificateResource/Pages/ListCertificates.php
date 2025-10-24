<?php

namespace App\Filament\Resources\CertificateResource\Pages;

use App\Filament\Resources\CertificateResource;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListCertificates extends ListRecords
{
    protected static string $resource = CertificateResource::class;

    protected function getTableQuery(): Builder
    {
        if (auth()->user()->isAdmin()) {
            return parent::getTableQuery();
        }

        return parent::getTableQuery()->whereHas('course', function ($query) {
            $query->where('user_id', auth()->id());
        });
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
