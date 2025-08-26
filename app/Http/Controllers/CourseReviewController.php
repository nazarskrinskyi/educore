<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CourseReviewController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'course_id' => ['nullable', 'integer', 'exists:courses,id'],
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:255'],
        ]);

        $user = $request->user();

        $exists = Review::where('user_id', $user->id)
            ->when($validated['course_id'] ?? null, fn($q) => $q->where('course_id', $validated['course_id']))
            ->exists();

        if ($exists) {
            return back()->withErrors(['review' => 'You already submitted a review.']);
        }

        $validated['user_id'] = $user->id;

        Review::create($validated);

        return back()->with('success', 'Review created successfully');
    }

    public function update(Request $request, Review $review): RedirectResponse
    {
        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:255'],
        ]);

        $review->update($validated);

        return back()->with('success', 'Review updated successfully');
    }

    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return back()->with('success', 'Review deleted successfully');
    }
}
