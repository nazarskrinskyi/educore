<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questionNumber = 1;
        for ($testId = 1; $testId <= 10; $testId++) {
            for ($i = 1; $i <= 4; $i++) {
                Question::factory()->create([
                    'test_id' => $testId,
                    'question_text' => "Question $questionNumber",
                    'question_type' => rand(1, 4),
                    'image_path' => null,
                    'video_path' => null,
                    'audio_path' => null,
                    'score' => rand(20, 30),
                ]);
                $questionNumber++;
            }
        }
    }
}
