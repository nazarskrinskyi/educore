<?php

namespace App\Http\Controllers;

use App\Enums\QuestionTypeEnum;
use App\Http\Requests\TestSaveProgressRequest;
use App\Http\Requests\TestSubmitRequest;
use App\Http\Resources\TestResource;
use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\TestResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class TestController extends Controller
{
    public function show(Test $test): Response
    {
        $test->load(['questions.answers']);

        return Inertia::render('Tests/Show', [
            'test' => (new TestResource($test))->resolve(),
            'previousAnswers' => null,
            'now' => now()->toIso8601String(),
        ]);
    }

    public function getProgress(Test $test): JsonResponse
    {
        $attempt = TestAttempt::with('answers')
            ->where('user_id', auth()->id())
            ->where('test_id', $test->id)
            ->where('is_completed', false)
            ->first();

        if (!$attempt) {
            return response()->json(null);
        }

        return response()->json($attempt);
    }

    public function saveProgress(TestSaveProgressRequest $data, Test $test): void
    {
        $user = auth()->user();

        $attempt = TestAttempt::firstOrCreate(
            ['user_id' => $user->id, 'test_id' => $test->id, 'is_completed' => false],
            ['elapsed_seconds' => 0]
        );

        if (isset($data['elapsed_seconds'])) {
            $attempt->elapsed_seconds = $data['elapsed_seconds'];
        }

        if (!empty($data['is_completed'])) {
            $attempt->is_completed = true;
        }

        $attempt->save();

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

    public function submit(TestSubmitRequest $validated, Test $test): Response|RedirectResponse
    {
        $test->load('questions.answers');

        $answersByQuestion = collect($validated['answers'])->keyBy('question_id');

        $totalScore = 0;
        $earnedScore = 0;

        DB::beginTransaction();
        try {
            foreach ($test->questions as $q) {
                $submitted = $answersByQuestion->get($q->id, []);
                dump($submitted);

//                $questionScore = $q->score ?? 1;
//                $totalScore += $questionScore;
//
//                $awarded = 0;
//                $type = (int)$q->question_type;
//
//                switch ($type) {
//                    case QuestionTypeEnum::MultipleChoice->value:
//                        $correctIds = $q->answers->where('is_correct', true)->pluck('id')->values();
//                        $selected = (int)($submitted['selected_answer_id'] ?? 0);
//                        if ($correctIds->count() === 1 && $correctIds->contains($selected)) {
//                            $awarded = $questionScore;
//                        }
//                        break;
//
//                    case QuestionTypeEnum::MultipleAnswer->value:
//                        $correctIds = $q->answers->where('is_correct', true)->pluck('id')->sort()->values();
//                        $selectedIds = collect($submitted['selected_answer_ids'] ?? [])->sort()->values();
//                        if ($correctIds->count() && $correctIds->values()->all() === $selectedIds->values()->all()) {
//                            $awarded = $questionScore;
//                        }
//                        break;
//
//                    case QuestionTypeEnum::TrueFalse->value:
//                        $awarded = $submitted['bool'] ? $questionScore : 0;
//                        break;
//
//                    case QuestionTypeEnum::ShortAnswer->value:
//                        $awarded = 0;
//                        break;
//                }
//
//                $earnedScore += $awarded;
            }
            dd(11);

            $percent = $totalScore > 0 ? round(($earnedScore / $totalScore) * 100) : 0;
            $passed = $percent >= ($test->pass_percentage ?? 70);

            TestResult::updateOrCreate(
                [
                    'test_id' => $test->id,
                    'user_id' => $validated->user()->id,
                ],
                [
                    'score' => $percent,
                    'passed' => $passed,
                    'completed_at' => now(),
                ]
            );

            DB::commit();

            TestAttempt::where([
                'test_id' => $test->id,
                'user_id' => $validated->user()->id,
            ])->delete();

            return redirect()->route('test.result', ['test' => $test->id]);
        } catch (Throwable $e) {
            DB::rollBack();
            report($e);
            return back()->withErrors(['submit' => 'Failed to submit test. Please try again.']);
        }
    }

    public function result(Test $test): Response|RedirectResponse
    {
        $userId = auth()->id();

        $result = TestResult::where('test_id', $test->id)
            ->where('user_id', $userId)
            ->firstOrFail();

        $test->load('questions.answers');

        $answers = collect($test->questions)->mapWithKeys(fn($q) => [
            $q->id => $q->answers->map(fn($a) => [
                'id' => $a->id,
                'answer_text' => $a->answer_text,
                'is_correct' => $a->is_correct,
            ]),
        ]);

        $detail = $test->questions->map(function($q) use ($result, $answers) {
            $userAnswer = $answers->where('question_id', $q->id)->first();
            return [
                'question_id' => $q->id,
                'question_type' => $q->question_type,
                'awarded' => $userAnswer->awarded ?? 0,
                'max_score' => $q->score ?? 1,
                'data' => $userAnswer->data ?? null,
            ];
        });

        return Inertia::render('Tests/Result', [
            'test' => $test,
            'result' => $result,
            'detail' => $detail,
        ]);
    }
}
