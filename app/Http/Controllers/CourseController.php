<?php

namespace App\Http\Controllers;

use App\Enums\CourseLevelEnum;
use App\Http\Resources\CourseResource;
use App\Http\Resources\LessonResource;
use App\Models\Category;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\Lesson;
use App\Repositories\Course\CourseRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use RuntimeException;

class CourseController extends Controller
{
    public function __construct(private readonly CourseRepositoryInterface $courseRepository)
    {
    }

    public function index(Request $request): Response
    {
        $courses = $this->courseRepository->getAllFilteredWithAllRelationsPaginated(6, $request);
        $categories = Category::whereHas('courses')->get();

        $minPrice = Course::min('price') / 100;
        $maxPrice = Course::max('price') / 100;

        return Inertia::render('Courses/Index', [
            'courses' => $courses,
            'filters' => $request->only(['search', 'category', 'price_min', 'price_max', 'is_free', 'difficulty', 'sorting']),
            'categories' => $categories,
            'priceRange' => [
                'min' => $minPrice,
                'max' => $maxPrice,
            ],
            'difficulties' => CourseLevelEnum::getValuesWithNames()
        ]);
    }

    public function show(string $slug): Response
    {
        $course = $this->courseRepository->getOneWithAllRelationsBySlug($slug);

        $course->in_cart = session()->has('cart.' . $course->id);

        $viewedKey = 'viewed_courses.' . $course->id;
        if (!session()->has($viewedKey)) {
            $course->increment('views');
            session()->put($viewedKey, now());
        }

        return Inertia::render('Courses/Show', [
            'course' => (new CourseResource($course))->resolve(),
        ]);
    }

    public function enroll(Course $course): Response
    {
        $userId = auth()->id();

        $course->owned = $userId &&
            ($this->courseRepository->isUserHasCourse($userId, $course->id) || $course->is_free);

        if ($course->owned && $this->courseRepository->isDoesntExist($userId, $course->id)) {
            $this->courseRepository->createCourseUser($userId, [], $course);

            return Inertia::render('Courses/Show', [
                'course' => (new CourseResource($course))->resolve(),
            ]);
        }

        throw new RuntimeException('You cannot enroll in this course');
    }

    public function enrollShow(Course $course, Lesson $lesson): Response
    {
        $course->load(['sections.lessons']);

        $course->owned = auth()->user() && $this->courseRepository->isUserHasCourse(auth()->id(), $course->id);

        $viewedKey = 'viewed_lessons.' . $lesson->id;
        if (!session()->has($viewedKey)) {
            $lesson->increment('views');
            session()->put($viewedKey, now());
        }

        return Inertia::render('Courses/Player', [
            'course' => $course,
            'lesson' => (new LessonResource($lesson))->resolve(),
        ]);
    }
}
