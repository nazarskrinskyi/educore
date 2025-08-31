<?php

namespace Database\Seeders;

use App\Models\Test;

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            Test::factory()->create([
                'title' => "Tests $i",
                'slug' => "test-$i",
                'description' => "Tests $i description",
                'duration' => $i * 60,
                'lesson_id' => $i,
                'course_id' => $i,
                'pass_percentage' => 70
            ]);
        }
    }
}
