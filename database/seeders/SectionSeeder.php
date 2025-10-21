<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        $sectionCountPerCourse = 4;
        $sectionId = 1;

        for ($courseId = 1; $courseId <= 10; $courseId++) {
            for ($i = 1; $i <= $sectionCountPerCourse; $i++) {
                Section::factory()->create([
                    'title' => "Section $sectionId",
                    'course_id' => $courseId,
                ]);
                $sectionId++;
            }
        }
    }
}
