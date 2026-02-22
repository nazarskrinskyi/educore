<?php

namespace Database\Seeders;

use App\Models\Lesson;
use Illuminate\Database\Seeder;

class LessonSeeder extends Seeder
{
    public function run(): void
    {
        // Verify required dependencies exist
        $adminUser = \App\Models\User::where('role', 'admin')->first();
        if (!$adminUser) {
            throw new \Exception('Admin user not found. Please ensure users are seeded first.');
        }

        $sections = \App\Models\Section::all();
        if ($sections->isEmpty()) {
            throw new \Exception('No sections found. Please ensure sections are seeded first.');
        }

        // Clear existing lessons to avoid duplicates on re-seeding
        Lesson::query()->delete();

        $lessonCountPerSection = 2;
        $lessonId = 1;

        foreach ($sections as $section) {
            for ($i = 1; $i <= $lessonCountPerSection; $i++) {
                $lessonTitle = "{$section->title} - Part {$i}";
                Lesson::create([
                    'title' => $lessonTitle,
                    'slug' => \Illuminate\Support\Str::slug($lessonTitle)."-{$lessonId}",
                    'content' => "This lesson covers important concepts in {$section->title}. You will learn practical skills and theoretical knowledge that can be applied in real-world scenarios. Detailed content and explanation for lesson {$lessonId}.",
                    'section_id' => $section->id,
                    'user_id' => $adminUser->id,
                    'image_path' => "https://picsum.photos/seed/lesson{$lessonId}/600/400",
                    'video_path' => 'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4',
                    'is_published' => true,
                    'views' => rand(500, 5000),
                ]);
                $lessonId++;
            }
        }
    }
}
