<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\JsonResponse;

class CourseProgressController extends Controller
{
    public function show(Course $course): JsonResponse
    {
        $progress = auth()->user()->courses()->where('course_id', $course->id)->first()?->pivot->progress_percent ?? 0;
        return response()->json(['progress_percent' => $progress]);
    }
}
