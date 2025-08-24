<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Models\Course;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CourseController extends Controller
{
    public function index(Request $request): Response
    {
        $courses = Course::with([
            'category',
            'instructor',
            'tags',
            'sections.lessons',
            'sections.lessons.tests',
            'reviews.user',
            'students',
        ])
            ->filter($request)
            ->paginate(6)
            ->through(fn($course) => new CourseResource($course));

        return Inertia::render('Courses/Index', [
            'courses' => $courses,
            'filters' => $request->only(['search', 'category', 'rating', 'price_min', 'price_max']),
        ]);
    }

    public function show(Request $request, string $slug): Response
    {
        $course = Course::with([
            'category',
            'instructor',
            'tags',
            'sections.lessons',
            'sections.lessons.tests',
            'reviews.user',
            'students',
        ])->where('slug', $slug)->firstOrFail();

        $course->owned = $request->user() ? $request->user()->orders()
        ->whereHas('items', fn($q) => $q->where('course_id', $course->id))
        ->exists() : false;

        $course->in_cart = session()->has('cart.' . $course->id);

        return Inertia::render('Courses/Show', [
            'course' => $course,
        ]);
    }
}
