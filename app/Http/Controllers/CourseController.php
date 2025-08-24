<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Lesson;
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
        ])->where('slug', $slug)
            ->through(fn($course) => new CourseResource($course))
            ->firstOrFail();

        $course->in_cart = session()->has('cart.' . $course->id);

        return Inertia::render('Courses/Show', [
            'course' => $course,
        ]);
    }

    public function enrollShow(Course $course, Lesson $lesson): Response
    {
        $course->load([
            'sections.lessons',
            'instructor',
            'reviews.user'
        ]);

        $course->owned = auth()->user() ? CourseUser::where('course_id', $course->id)
            ->where('user_id', auth()->id())
            ->exists() : false;

        return Inertia::render('Courses/Player', [
            'course' => $course,
            'lesson' => $lesson,
        ]);
    }
}
