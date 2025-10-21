<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Course::factory()->create([
                'title' => "Course $i",
                'slug' => "course-$i",
                'description' => "Course $i description with advanced topics.",
                'price' => 10000 * $i,
                'category_id' => $i,
                'user_id' => 1,
                'image_path' => "https://picsum.photos/seed/course$i/600/400",
                'video_path' => "https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4",
                'is_published' => true,
                'views' => rand(1000, 20000),
                'is_free' => $i % 2 === 0,
                'level' => rand(1, 3),
                'duration' => rand(30, 180),
            ]);
        }
    }
}
