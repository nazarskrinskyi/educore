<?php

namespace Database\Seeders;

use App\Models\Lesson;
use App\Models\Test;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        // Verify required dependencies exist
        $adminUser = \App\Models\User::where('role', 'admin')->first();
        if (!$adminUser) {
            throw new \Exception('Admin user not found. Please ensure users are seeded first.');
        }

        $lessons = Lesson::with('section.course')->get();
        if ($lessons->isEmpty()) {
            throw new \Exception('No lessons found. Please ensure lessons are seeded first.');
        }

        // Clear existing tests to avoid duplicates on re-seeding
        Test::query()->delete();

        foreach ($lessons as $lesson) {
            // Verify section and course relationships exist
            if (!$lesson->section) {
                \Log::warning("Lesson {$lesson->id} has no section. Skipping test creation.");

                continue;
            }

            if (!$lesson->section->course) {
                \Log::warning("Section {$lesson->section->id} has no course. Skipping test creation for lesson {$lesson->id}.");

                continue;
            }

            $courseId = $lesson->section->course_id;

            $testCount = rand(1, 2);

            for ($i = 1; $i <= $testCount; $i++) {
                Test::create([
                    'title' => "Test for {$lesson->title} #{$i}",
                    'slug' => "test-lesson-{$lesson->id}-{$i}",
                    'description' => "Evaluation test for {$lesson->title}. This test will assess your understanding of the key concepts covered in this lesson.",
                    'duration' => rand(300, 1200), // 5-20 minutes in seconds
                    'user_id' => $adminUser->id,
                    'lesson_id' => $lesson->id,
                    'course_id' => $courseId,
                    'pass_percentage' => rand(60, 90),
                ]);
            }
        }
    }
}
