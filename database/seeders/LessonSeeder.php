<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        $lessonCountPerSection = 2;
        $lessonId = 1;

        for ($sectionId = 1; $sectionId <= 40; $sectionId++) {
            for ($i = 1; $i <= $lessonCountPerSection; $i++) {
                Lesson::factory()->create([
                    'title' => "Lesson $lessonId",
                    'slug' => "lesson-$lessonId",
                    'content' => "Lesson $lessonId detailed content and explanation.",
                    'section_id' => $sectionId,
                    'user_id' => 1,
                    'image_path' => "https://picsum.photos/seed/lesson$lessonId/600/400",
                    'video_path' => "https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4",
                    'is_published' => true,
                    'views' => rand(500, 5000),
                ]);
                $lessonId++;
            }
        }
    }
}
