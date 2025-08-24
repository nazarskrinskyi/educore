<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Course::factory()->create(
                [
                    'title' => "Course $i",
                    'slug' => "course-$i",
                    'description' => "Course $i description",
                    'price' => 10000 * $i,
                    'category_id' => $i,
                    'instructor_id' => 1,
                    'image_path' => null,
                    'video_path' => null,
                    'is_published' => true,
                    'views' => 100 * $i,
                    'is_free' => false,
                    'level' => rand(1, 3),
                    'duration' => $i * 60
                ]
            );
        }
    }
}
