<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;

class CourseReviewController extends Controller
{
    public function store(CourseRequest $validated): RedirectResponse
    {
        $user = $validated->user();

        $exists = Review::where('user_id', $user->id)
            ->when($validated['course_id'] ?? null, fn($q) => $q->where('course_id', $validated['course_id']))
            ->exists();

        if ($exists) {
            return back()->withErrors(['review' => 'You already submitted a review.']);
        }

        $validated['user_id'] = $user->id;

        Review::create(array_filter($validated->all()));

        return back()->with('success', 'Review created successfully');
    }

    public function update(CourseRequest $validated, Review $review): RedirectResponse
    {
        $review->update(array_filter($validated->all()));

        return back()->with('success', 'Review updated successfully');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return back()->with('success', 'Review deleted successfully');
    }
}
