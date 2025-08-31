<?php

declare(strict_types=1);

namespace App\Repositories\Course;

use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\CourseUser;
use Illuminate\Http\Request;

class CourseRepository implements CourseRepositoryInterface
{
    public function getAllFilteredWithAllRelationsPaginated(int $perPage, Request $request): array
    {
        return Course::with([
            'category',
            'instructor',
            'tags',
            'sections.lessons',
            'sections.lessons.tests',
            'reviews.user',
            'users',
        ])
            ->filter($request)
            ->paginate(6)
            ->through(fn($course) => new CourseResource($course));
    }

    public function getOneWithAllRelationsBySlug(string $slug): Course
    {
        return Course::with([
            'category',
            'instructor',
            'tags',
            'sections.lessons',
            'sections',
            'sections.lessons.tests',
            'reviews.user',
            'users',
        ])->where('slug', $slug)->firstOrFail();
    }

    public function isUserHasCourse(int $userId, int $courseId): bool
    {
        return CourseUser::where('course_id', $courseId)
            ->where('user_id', $userId)
            ->exists();
    }
}
