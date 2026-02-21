<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        // Verify courses exist
        $courses = \App\Models\Course::all();
        if ($courses->isEmpty()) {
            throw new \Exception('No courses found. Please ensure courses are seeded first.');
        }

        // Clear existing sections to avoid duplicates on re-seeding
        Section::query()->delete();

        $sectionCountPerCourse = 4;
        $sectionTitles = [
            'Introduction and Fundamentals',
            'Core Concepts and Principles',
            'Advanced Techniques',
            'Real-World Projects and Practice',
        ];

        foreach ($courses as $course) {
            for ($i = 0; $i < $sectionCountPerCourse; $i++) {
                Section::create([
                    'title' => $sectionTitles[$i] ?? "Section " . ($i + 1),
                    'course_id' => $course->id,
                ]);
            }
        }
    }
}
