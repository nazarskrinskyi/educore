<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class CourseController extends Controller
{
    public function show($slug): Response
    {
        $course = Course::with([
            'category',
            'instructor',
            'tags',
            'lessons.tests',
            'reviews.user',
            'students',
        ])->where('slug', $slug)->firstOrFail();

        $course->price = (int) ($course->price / 100);
        $course->video_path = Storage::url($course->video_path);
        $course->image_path = Storage::url($course->image_path);

        return Inertia::render('Courses/Show', [
            'course' => $course,
        ]);
    }
}
