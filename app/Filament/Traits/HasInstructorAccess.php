<?php

declare(strict_types=1);

namespace App\Filament\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasInstructorAccess
{
    /**
     * Scope query to show only instructor's own records based on user_id
     */
    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();

        if (auth()->user()->isAdmin()) {
            return $query;
        }

        return $query->where('user_id', auth()->id());
    }
}
