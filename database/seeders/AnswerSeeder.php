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
        foreach (Question::all() as $key => $question) {
            switch ($question->question_type) {
                case QuestionTypeEnum::MultipleChoice->value:
                    Answer::factory()->create([
                        'question_id' => $question->id,
                        'answer_text' => 'Correct Answer ' . $key + 1,
                        'is_correct' => true,
                    ]);

                    Answer::factory(3)->create([
                        'question_id' => $question->id,
                        'answer_text' => 'Wrong Answer ' . $key + 1,
                        'is_correct' => false,
                    ]);
                    break;

                case QuestionTypeEnum::MultipleAnswer->value:
                    Answer::factory(2)->create([
                        'question_id' => $question->id,
                        'answer_text' => 'Correct Answer ' . $key + 1,
                        'is_correct' => true,
                    ]);

                    Answer::factory(2)->create([
                        'question_id' => $question->id,
                        'answer_text' => 'Wrong Answer ' . $key + 1,
                        'is_correct' => false,
                    ]);
                    break;

                case QuestionTypeEnum::TrueFalse->value:
                    Answer::create([
                        'question_id' => $question->id,
                        'bool' => true,
                        'is_correct' => true,
                    ]);

                    Answer::create([
                        'question_id' => $question->id,
                        'bool' => false,
                        'is_correct' => false,
                    ]);
                    break;

                case QuestionTypeEnum::ShortAnswer->value:
                    Answer::create([
                        'question_id' => $question->id,
                        'answer_text' => 'Sample short answer',
                        'is_correct' => true,
                    ]);
                    break;
            }
        }
    }
}
