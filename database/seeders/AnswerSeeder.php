<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Database\Seeder;
use App\Enums\QuestionTypeEnum;

class AnswerSeeder extends Seeder
{
    public function run(): void
    {
        // Verify required dependencies exist
        $adminUser = \App\Models\User::where('role', 'admin')->first();
        if (!$adminUser) {
            throw new \Exception('Admin user not found. Please ensure users are seeded first.');
        }

        $questions = Question::all();
        if ($questions->isEmpty()) {
            throw new \Exception('No questions found. Please ensure questions are seeded first.');
        }

        // Clear existing answers to avoid duplicates on re-seeding
        Answer::query()->delete();

        foreach ($questions as $key => $question) {
            switch ($question->question_type) {
                case QuestionTypeEnum::MultipleChoice->value:
                    // Create 1 correct answer
                    Answer::create([
                        'question_id' => $question->id,
                        'user_id' => $adminUser->id,
                        'answer_text' => 'Correct Answer ' . ($key + 1),
                        'is_correct' => true,
                    ]);

                    // Create 3 wrong answers
                    for ($i = 1; $i <= 3; $i++) {
                        Answer::create([
                            'question_id' => $question->id,
                            'user_id' => $adminUser->id,
                            'answer_text' => 'Wrong Answer ' . ($key + 1) . ' Option ' . $i,
                            'is_correct' => false,
                        ]);
                    }
                    break;

                case QuestionTypeEnum::MultipleAnswer->value:
                    // Create 2 correct answers
                    for ($i = 1; $i <= 2; $i++) {
                        Answer::create([
                            'question_id' => $question->id,
                            'user_id' => $adminUser->id,
                            'answer_text' => 'Correct Answer ' . ($key + 1) . ' Option ' . $i,
                            'is_correct' => true,
                        ]);
                    }

                    // Create 2 wrong answers
                    for ($i = 1; $i <= 2; $i++) {
                        Answer::create([
                            'question_id' => $question->id,
                            'user_id' => $adminUser->id,
                            'answer_text' => 'Wrong Answer ' . ($key + 1) . ' Option ' . $i,
                            'is_correct' => false,
                        ]);
                    }
                    break;

                case QuestionTypeEnum::TrueFalse->value:
                    // Create True option (correct)
                    Answer::create([
                        'question_id' => $question->id,
                        'user_id' => $adminUser->id,
                        'bool' => true,
                        'is_correct' => true,
                    ]);

                    // Create False option (incorrect)
                    Answer::create([
                        'question_id' => $question->id,
                        'user_id' => $adminUser->id,
                        'bool' => false,
                        'is_correct' => false,
                    ]);
                    break;

                case QuestionTypeEnum::ShortAnswer->value:
                    // Create sample correct answer
                    Answer::create([
                        'question_id' => $question->id,
                        'user_id' => $adminUser->id,
                        'answer_text' => 'Sample short answer for question ' . ($key + 1),
                        'is_correct' => true,
                    ]);
                    break;

                default:
                    \Log::warning("Unknown question type {$question->question_type} for question {$question->id}. Skipping answer creation.");
                    break;
            }
        }
    }
}
