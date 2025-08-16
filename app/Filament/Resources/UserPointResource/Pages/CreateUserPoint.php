<?php

namespace App\Filament\Resources\UserPointResource\Pages;

use App\Filament\Resources\UserPointResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateUserPoint extends CreateRecord
{
    protected static string $resource = UserPointResource::class;
}
