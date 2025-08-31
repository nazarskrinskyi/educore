<?php

declare(strict_types=1);

namespace App\Services;

use App\Enums\QuestionTypeEnum;
use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\TestResult;
use Illuminate\Support\Facades\DB;
use Throwable;

class TestService
{
    public function saveAttempt(array $data, TestAttempt $attempt): void
    {
        foreach ($data['answers'] as $answerData) {
            $attempt->answers()->updateOrCreate(
                ['question_id' => $answerData['question_id']],
                [
                    'selected_answer_id' => $answerData['selected_answer_id'] ?? null,
                    'selected_answer_ids' => isset($answerData['selected_answer_ids']) ? json_encode($answerData['selected_answer_ids']) : null,
                    'bool' => $answerData['bool'] ?? null,
                    'text' => $answerData['text'] ?? null,
                ]
            );
        }
    }

    /**
     * @throws Throwable
     */
    public function submit(Test $test, array $answers, int $userId): array
    {
        $answersByQuestion = collect($answers)->keyBy('question_id');

        $totalScore = 0;
        $earnedScore = 0;
        $details = [];

        foreach ($test->questions as $question) {
            $submitted = $answersByQuestion->get($question->id, []);
            $questionScore = $question->score ?? 1;
            $totalScore += $questionScore;

            $awarded = $this->evaluateAnswer($question, $submitted, $questionScore);

            $earnedScore += $awarded;

            $details[] = [
                'question_id'     => $question->id,
                'type'            => (int) $question->question_type,
                'user_answer'     => $submitted,
                'awarded'         => $awarded,
                'max_score'       => $questionScore,
                'correct_answers' => $question->answers->where('is_correct', true)->values(),
            ];
        }

        $percent = $totalScore > 0 ? round(($earnedScore / $totalScore) * 100) : 0;
        $passed  = $percent >= ($test->pass_percentage ?? 70);

        DB::beginTransaction();
        try {
            TestResult::updateOrCreate(
                [
                    'test_id' => $test->id,
                    'user_id' => $userId,
                ],
                [
                    'score'        => $percent,
                    'passed'       => $passed,
                    'completed_at' => now(),
                    'details'      => $details,
                ]
            );

            TestAttempt::where([
                'test_id' => $test->id,
                'user_id' => $userId,
            ])->delete();

            DB::commit();

            return [
                'percent' => $percent,
                'passed'  => $passed,
            ];
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function evaluateAnswer($question, array $submitted, int $questionScore): int
    {
        $type = (int) $question->question_type;

        return match ($type) {
            QuestionTypeEnum::MultipleChoice->value => $this->checkMultipleChoice($question, $submitted, $questionScore),
            QuestionTypeEnum::MultipleAnswer->value => $this->checkMultipleAnswer($question, $submitted, $questionScore),
            QuestionTypeEnum::TrueFalse->value      => $this->checkTrueFalse($question, $submitted, $questionScore),
            QuestionTypeEnum::ShortAnswer->value    => $this->checkShortAnswer($question, $submitted, $questionScore),
            default                                 => 0,
        };
    }

    private function checkMultipleChoice($question, array $submitted, int $score): int
    {
        $correctIds = $question->answers->where('is_correct', true)->pluck('id');
        $selected   = (int) ($submitted['selected_answer_id'] ?? 0);

        return ($correctIds->count() === 1 && $correctIds->contains($selected)) ? $score : 0;
    }

    private function checkMultipleAnswer($question, array $submitted, int $score): int
    {
        $correctIds  = $question->answers->where('is_correct', true)->pluck('id')->sort()->values();
        $selectedIds = collect($submitted['selected_answer_ids'] ?? [])->sort()->values();

        return ($correctIds->count() && $correctIds->all() === $selectedIds->all()) ? $score : 0;
    }

    private function checkTrueFalse($question, array $submitted, int $score): int
    {
        $correctBool = (bool) $question->answers->where('is_correct', true)->first()?->bool;
        $selected    = (bool) ($submitted['bool'] ?? false);

        return ($selected === $correctBool) ? $score : 0;
    }

    private function checkShortAnswer($question, array $submitted, int $score): int
    {
        $correctText = strtolower(trim($question->answers->where('is_correct', true)->first()?->answer_text ?? ''));
        $selected    = strtolower(trim((string) ($submitted['text'] ?? '')));

        return ($correctText !== '' && $correctText === $selected) ? $score : 0;
    }
}
