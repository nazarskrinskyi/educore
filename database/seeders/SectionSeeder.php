<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        $courseId = 1;
        for ($i = 1; $i <= 40; $i++) {
            if ($i > 4 && $i % 4 == 0) {
                $courseId++;
            }
            Section::factory()->create([
                'title' => "Section $i",
                'course_id' => $courseId,
            ]);
        }
    }
}
