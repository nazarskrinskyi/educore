<?php

declare(strict_types=1);

namespace App\Repositories\CourseReview;

use App\Models\Review;

interface CourseReviewRepositoryInterface
{
    public function isUserHasCourseReview(int $userId, int $courseId): bool;

    public function create(array $data): void;

    public function update(array $data, Review $review): void;

    public function delete(Review $review): void;
}
