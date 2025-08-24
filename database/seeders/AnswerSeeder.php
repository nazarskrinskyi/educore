<?php

namespace Database\Seeders;

use App\Models\Answer;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $answerNumber = 1;
        for ($questionId = 1; $questionId <= 40; $questionId++) {
            for ($i = 1; $i <= 4; $i++) {
                Answer::factory()->create([
                    'question_id' => $questionId,
                    'answer_text' => "Answer $answerNumber",
                    'is_correct' => $i === 1,
                    'answer_image' => null,
                    'answer_video' => null,
                    'answer_audio' => null
                ]);
                $answerNumber++;
            }
        }
    }
}
