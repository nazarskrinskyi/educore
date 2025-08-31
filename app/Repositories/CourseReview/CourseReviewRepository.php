<?php

declare(strict_types=1);

namespace App\Repositories\CourseReview;

use App\Models\Review;

class CourseReviewRepository implements CourseReviewRepositoryInterface
{
    public function isUserHasCourseReview(int $userId, int $courseId): bool
    {
        return Review::where('user_id', $userId)
            ->when($courseId, fn($q) => $q->where('course_id', $courseId))
            ->exists();
    }

    public function create(array $data): void
    {
        Review::create($data);
    }

    public function update(array $data, Review $review): void
    {
        $review->update($data);
    }

    public function delete(Review $review): void
    {
        $review->delete();
    }
}
