<?php

namespace Database\Seeders;

use App\Models\Test;
use App\Models\Lesson;
use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    public function run(): void
    {
        $lessons = Lesson::all();

        foreach ($lessons as $lesson) {
            $courseId = $lesson->section->course_id;

            $testCount = rand(1, 2);

            for ($i = 1; $i <= $testCount; $i++) {
                Test::factory()->create([
                    'title' => "Test for $lesson->title #$i",
                    'slug' => "test-lesson-$lesson->id-$i",
                    'description' => "Evaluation test for $lesson->title.",
                    'duration' => rand(300, 1200),
                    'user_id' => 1,
                    'lesson_id' => $lesson->id,
                    'course_id' => $courseId,
                    'pass_percentage' => rand(60, 90),
                ]);
            }
        }
    }
}
