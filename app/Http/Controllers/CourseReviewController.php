<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Review;
use App\Repositories\CourseReview\CourseReviewRepositoryInterface;
use Illuminate\Http\RedirectResponse;

class CourseReviewController extends Controller
{
    public function __construct(private readonly CourseReviewRepositoryInterface $courseReviewRepository)
    {
    }

    public function store(CourseRequest $validated): RedirectResponse
    {
        $user = $validated->user();

        $exists = $this->courseReviewRepository->isUserHasCourseReview($user->id, $validated['course_id']);

        if ($exists) {
            return back()->withErrors(['review' => 'You already submitted a review.']);
        }

        $validated['user_id'] = $user->id;

        $this->courseReviewRepository->create(array_filter($validated->all()));

        return back()->with('success', 'Review created successfully');
    }

    public function update(CourseRequest $validated, Review $review): RedirectResponse
    {
        $this->courseReviewRepository->update(array_filter($validated->all()), $review);

        return back()->with('success', 'Review updated successfully');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $this->courseReviewRepository->delete($review);

        return back()->with('success', 'Review deleted successfully');
    }
}
