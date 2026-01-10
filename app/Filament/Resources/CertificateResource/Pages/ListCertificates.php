<?php

namespace App\Filament\Resources\CertificateResource\Pages;

use App\Filament\Resources\CertificateResource;
use App\Filament\Traits\HasInstructorAccessViaRelation;
use Filament\Resources\Pages\ListRecords;

class ListCertificates extends ListRecords
{
    use HasInstructorAccessViaRelation;

    protected static string $resource = CertificateResource::class;

    protected function getInstructorRelationship(): string
    {
        return 'course';
    }

    protected function getHeaderActions(): array
    {
        return [];
    }
}
