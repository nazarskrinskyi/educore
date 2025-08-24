<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\NewEnrollment;
use App\Models\Course;
use App\Models\CourseUser;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class CourseService
{
    /**
     * Enroll all students from the cart to the courses.
     *
     * @param array $cart
     * @return void
     */
    public function enrollStudent(array $cart): void
    {
        $user = auth()->user();

        if (!$user || empty($cart)) {
            return;
        }

        DB::transaction(function () use ($user, $cart) {
            foreach ($cart as $item) {
                $courseId = $item['id'];

                $course = Course::find($courseId);
                if (!$course) {
                    continue;
                }

                CourseUser::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'course_id' => $course->id,
                        'enrolled_at' => now(),
                        'progress_percent' => 0,
                    ]
                );
            }
        });
    }

    /**
     * Notify instructors about new enrollment
     *
     * @param array $cart
     * @return void
     */
    public function notifyInstructors(array $cart): void
    {
        foreach ($cart as $item) {
            $course = Course::find($item['id']);

            if ($course && $course->instructor) {
                Mail::to($course->instructor->email)->send(new NewEnrollment($course));
            }
        }
    }

    /**
     * Check if a user already owns a course.
     */
    public function isOwnedByUser(Course $course, User $user): bool
    {
        return $course->students()->where('user_id', $user->id)->exists();
    }
}
