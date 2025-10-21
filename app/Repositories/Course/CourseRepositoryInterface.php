<?php

declare(strict_types=1);

namespace App\Repositories\Course;


use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface CourseRepositoryInterface
{
    public function getAllFilteredWithAllRelationsPaginated(int $perPage, Request $request): LengthAwarePaginator;

    public function getOneWithAllRelationsBySlug(string $slug): Course;

    public function isUserHasCourse(int $userId, int $courseId): bool;

    public function isDoesntExist(int $userId, int $courseId): bool;

    public function createCourseUser(int $userId, array $cart = [], ?Course $course = null): void;

    public function getCourseById(int $courseId): ?Course;
}
