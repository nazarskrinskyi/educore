<?php

namespace Database\Seeders;

use App\Models\Question;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verify required dependencies exist
        $adminUser = \App\Models\User::where('role', 'admin')->first();
        if (!$adminUser) {
            throw new \Exception('Admin user not found. Please ensure users are seeded first.');
        }

        $tests = \App\Models\Test::all();
        if ($tests->isEmpty()) {
            throw new \Exception('No tests found. Please ensure tests are seeded first.');
        }

        // Clear existing questions to avoid duplicates on re-seeding
        Question::query()->delete();

        $questionNumber = 1;
        $questionTypes = [1, 2, 3, 4]; // MultipleChoice, MultipleAnswer, TrueFalse, ShortAnswer

        foreach ($tests as $test) {
            $questionsPerTest = rand(3, 5); // 3-5 questions per test

            for ($i = 1; $i <= $questionsPerTest; $i++) {
                Question::create([
                    'test_id' => $test->id,
                    'user_id' => $adminUser->id,
                    'question_text' => "Question {$questionNumber}: What is the correct answer for this test question?",
                    'question_type' => $questionTypes[array_rand($questionTypes)],
                    'image_path' => null,
                    'video_path' => null,
                    'audio_path' => null,
                    'score' => rand(5, 10), // 5-10 points per question
                ]);
                $questionNumber++;
            }
        }
    }
}
