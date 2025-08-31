<?php

declare(strict_types=1);

namespace App\Repositories\Course;


use App\Models\Course;
use Illuminate\Http\Request;

interface CourseRepositoryInterface
{
    public function getAllFilteredWithAllRelationsPaginated(int $perPage, Request $request): array;

    public function getOneWithAllRelationsBySlug(string $slug): Course;

    public function isUserHasCourse(int $userId, int $courseId): bool;

    public function createCourseUser(int $userId, array $cart): void;

    public function getCourseById(int $courseId): ?Course;
}
