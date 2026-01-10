<?php

declare(strict_types=1);

namespace App\Filament\Traits;

use Illuminate\Database\Eloquent\Builder;

trait HasInstructorAccessViaRelation
{
    /**
     * Scope query to show only instructor's own records via a relationship
     *
     * @return string The relationship name to filter by (e.g., 'course', 'section.course')
     */
    abstract protected function getInstructorRelationship(): string;

    /**
     * Scope query to show only instructor's own records through a relationship
     */
    protected function getTableQuery(): Builder
    {
        $query = parent::getTableQuery();

        if (auth()->user()->isAdmin()) {
            return $query;
        }

        return $query->whereHas($this->getInstructorRelationship(), function ($query) {
            $query->where('user_id', auth()->id());
        });
    }
}
