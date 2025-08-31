<?php

namespace App\Http\Controllers;

use App\Http\Resources\CourseResource;
use App\Http\Resources\LessonResource;
use App\Models\Course;
use App\Models\Lesson;
use App\Repositories\Course\CourseRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CourseController extends Controller
{
    public function __construct(private readonly CourseRepositoryInterface $courseRepository)
    {
    }

    public function index(Request $request): Response
    {
        $courses = $this->courseRepository->getAllFilteredWithAllRelationsPaginated(6, $request);

        return Inertia::render('Courses/Index', [
            'courses' => $courses,
            'filters' => $request->only(['search', 'category', 'rating', 'price_min', 'price_max']),
        ]);
    }

    public function show(string $slug): Response
    {
        $course = $this->courseRepository->getOneWithAllRelationsBySlug($slug);

        $course->in_cart = session()->has('cart.' . $course->id);

        return Inertia::render('Courses/Show', [
            'course' => (new CourseResource($course))->resolve(),
        ]);
    }

    public function enrollShow(Course $course, Lesson $lesson): Response
    {
        $course->load(['sections.lessons']);

        $course->owned = auth()->user() && $this->courseRepository->isUserHasCourse(auth()->id(), $course->id);

        return Inertia::render('Courses/Player', [
            'course' => $course,
            'lesson' => (new LessonResource($lesson))->resolve(),
        ]);
    }
}
