<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Course;
use App\Models\User;
use App\Models\Certificate;

class CourseProgressService
{
    public function completeCourse(User $user, Course $course): Certificate|null
    {
        $progress = $user->courses()->where('course_id', $course->id)->first()?->pivot->progress_percent ?? 0;
        if ($progress < 90) {
            return null;
        }

        $existing = Certificate::where('user_id', $user->id)->where('course_id', $course->id)->first();
        if ($existing) {
            return $existing;
        }

        return Certificate::generate($user, $course);
    }

    /**
     * Calculate the progress of a user in a course (0-100%).
     */
    public function calculate(User $user, Course $course): float
    {
        $lessons = $course->lessons()->get();
        $tests   = $course->lessons()->with('tests')->get()->pluck('tests')->flatten();

        $totalItems = $lessons->count() + $tests->count();
        if ($totalItems === 0) return 0;

        $completedLessons = $lessons->filter(fn($lesson) =>
        $lesson->users()->where('user_id', $user->id)->exists()
        )->count();

        $completedTests = $tests->filter(fn($test) =>
        $test->results()->where('user_id', $user->id)->where('passed', true)->exists()
        )->count();

        return round((($completedLessons + $completedTests) / $totalItems) * 100, 2);
    }

    /**
     * Update progress for a user in a course and generate a certificate if 100% is reached.
     */
    public function updateProgress(User $user, Course $course): void
    {
        $progress = $this->calculate($user, $course);
        // Update progress in pivot table course_user
        $user->courses()->updateExistingPivot($course->id, ['progress_percent' => $progress]);

        // if 100% — generate certificate
        if ($progress >= 90) {
            Certificate::generate($user, $course);
        }
    }
}
