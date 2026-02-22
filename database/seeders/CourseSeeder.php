<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        // Verify required dependencies exist
        $adminUser = \App\Models\User::where('role', 'admin')->first();
        if (!$adminUser) {
            throw new \Exception('Admin user not found. Please ensure users are seeded first.');
        }

        $categoryCount = \App\Models\Category::count();
        if ($categoryCount < 10) {
            throw new \Exception("Not enough categories. Expected 10, found {$categoryCount}. Please ensure categories are seeded first.");
        }

        // Clear existing courses to avoid duplicates on re-seeding
        Course::query()->delete();

        $courses = [
            ['title' => 'Complete Web Development Bootcamp', 'category_id' => 1, 'price' => 4999, 'level' => 1, 'duration' => 120, 'is_free' => false],
            ['title' => 'Advanced JavaScript Masterclass', 'category_id' => 1, 'price' => 7999, 'level' => 3, 'duration' => 90, 'is_free' => false],
            ['title' => 'iOS App Development with Swift', 'category_id' => 2, 'price' => 8999, 'level' => 2, 'duration' => 100, 'is_free' => false],
            ['title' => 'Android Development for Beginners', 'category_id' => 2, 'price' => 0, 'level' => 1, 'duration' => 80, 'is_free' => true],
            ['title' => 'Machine Learning A-Z', 'category_id' => 3, 'price' => 9999, 'level' => 3, 'duration' => 150, 'is_free' => false],
            ['title' => 'AWS Certified Solutions Architect', 'category_id' => 4, 'price' => 0, 'level' => 2, 'duration' => 110, 'is_free' => true],
            ['title' => 'Ethical Hacking & Penetration Testing', 'category_id' => 5, 'price' => 12999, 'level' => 3, 'duration' => 140, 'is_free' => false],
            ['title' => 'SQL & Database Design Fundamentals', 'category_id' => 6, 'price' => 3999, 'level' => 1, 'duration' => 60, 'is_free' => false],
            ['title' => 'Docker & Kubernetes Mastery', 'category_id' => 7, 'price' => 0, 'level' => 2, 'duration' => 95, 'is_free' => true],
            ['title' => 'UI/UX Design Principles', 'category_id' => 8, 'price' => 5999, 'level' => 1, 'duration' => 70, 'is_free' => false],
        ];

        foreach ($courses as $index => $courseData) {
            $i = $index + 1;
            Course::create([
                'title' => $courseData['title'],
                'slug' => \Illuminate\Support\Str::slug($courseData['title']),
                'description' => "Comprehensive course covering {$courseData['title']}. Learn from industry experts with hands-on projects and real-world examples.",
                'price' => $courseData['price'],
                'category_id' => $courseData['category_id'],
                'user_id' => $adminUser->id,
                'image_path' => "https://picsum.photos/seed/course$i/600/400",
                'video_path' => 'https://sample-videos.com/video123/mp4/720/big_buck_bunny_720p_1mb.mp4',
                'is_published' => true,
                'views' => rand(1000, 20000),
                'is_free' => $courseData['is_free'],
                'level' => $courseData['level'],
                'duration' => $courseData['duration'],
            ]);
        }
    }
}
