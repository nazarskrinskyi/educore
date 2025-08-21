<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function __invoke(): Response
    {
        $courses = Course::with([
            'instructor:id,name',
            'category:id,name,slug',
            'tags:id,name,slug',
        ])->get(['id', 'title', 'slug', 'image_path', 'is_free', 'price', 'instructor_id', 'category_id']);

        $courses->transform(function ($course) {
            $course->image_path = Storage::url($course->image_path);
            $course->price = (int) ($course->price / 100);
            $course->in_cart = session()->has('cart.' . $course->id);
            return $course;
        });


        return Inertia::render('About', [
            'courses' => $courses,
        ]);
    }
}
