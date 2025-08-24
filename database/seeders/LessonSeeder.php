<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sectionId = 1;
        for ($i = 1; $i <= 80; $i++) {
            if ($i > 4 && $i % 4 == 0) {
                $sectionId++;
            }
            Lesson::factory()->create(
                [
                    'title' => "Lesson $i",
                    'slug' => "lesson-$i",
                    'content' => "Lesson $i description",
                    'section_id' => $sectionId,
                    'video_path' => null,
                    'image_path' => null,
                    'is_published' => true,
                    'views' => 100 * $i,
                ]
            );
            }
    }
}
