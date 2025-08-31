<?php

declare(strict_types=1);

namespace App\Services;

use App\Mail\NewEnrollment;
use App\Models\Course;
use App\Models\CourseUser;
use App\Repositories\Course\CourseRepositoryInterface;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

readonly class CourseService
{
    public function __construct(private CourseRepositoryInterface $courseRepository)
    {
    }

    /**
     * Enroll all students from the cart to the courses.
     *
     * @param array $cart
     * @return void
     */
    public function enrollUser(array $cart): void
    {
        $userId = auth()->id();

        if (!$userId || empty($cart)) {
            return;
        }

        $this->courseRepository->createCourseUser($userId, $cart);
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
            $course = $this->courseRepository->getCourseById($item['id']);

            if ($course && $course->instructor) {
                Mail::to($course->instructor->email)->send(new NewEnrollment($course));
            }
        }
    }
}
