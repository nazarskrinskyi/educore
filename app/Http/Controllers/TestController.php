<?php

namespace App\Http\Controllers;

use App\Enums\QuestionTypeEnum;
use App\Http\Requests\TestRequest;
use App\Http\Resources\TestResource;
use App\Models\Test;
use App\Models\TestAttempt;
use App\Models\TestResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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

        return response()->json($attempt);
    }

    public function saveProgress(TestRequest $data, Test $test): \Illuminate\Http\Response
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
                    'selected_answer_ids' => $answerData['selected_answer_ids'] ?? null,
                    'bool' => $answerData['bool'] ?? null,
                    'text' => $answerData['text'] ?? null,
                ]
            );
        }

        return response()->noContent();
    }

    public function submit(Request $request, Test $test): RedirectResponse
    {
        $test->load(['questions.answers']);

        $validated = $request->validate([
            'answers' => ['required', 'array'],
            'answers.*.question_id' => ['required', 'integer', 'exists:questions,id'],
            'answers.*.selected_answer_id' => ['nullable', 'integer', 'exists:answers,id'],
            'answers.*.selected_answer_ids' => ['nullable', 'array'],
            'answers.*.selected_answer_ids.*' => ['integer', 'exists:answers,id'],
            'answers.*.bool' => ['nullable', 'boolean'],
            'answers.*.text' => ['nullable', 'string'],
            'elapsed_seconds' => ['nullable', 'integer', 'min:0'],
        ]);

        $answersByQuestion = collect($validated['answers'])->keyBy('question_id');

        $score = 0;
        $maxAuto = 0;
        $detail = [];

        DB::beginTransaction();
        try {
            foreach ($test->questions as $q) {
                $submitted = $answersByQuestion->get($q->id, []);

                $resultForQ = [
                    'question_id' => $q->id,
                    'question_type' => (int) $q->question_type,
                    'correct' => null,
                    'awarded' => 0,
                    'auto_gradable' => false,
                    'data' => $submitted,
                ];

                $type = (int) $q->question_type;
                $correctIds = $q->answers->where('is_correct', true)->pluck('id')->values();

                $isAutoGradable = in_array($type, [
                    QuestionTypeEnum::MultipleChoice->value,
                    QuestionTypeEnum::TrueFalse->value,
                    QuestionTypeEnum::MultipleChoiceAndTrueFalse->value,
                ]);

                if ($isAutoGradable) {
                    $maxAuto += 1;
                    $resultForQ['auto_gradable'] = true;

                    switch ($type) {
                        case QuestionTypeEnum::MultipleChoice->value:
                            $selected = (int) ($submitted['selected_answer_id'] ?? 0);
                            $isCorrect = $correctIds->count() === 1 && $correctIds->contains($selected);
                            $resultForQ['correct'] = $isCorrect;
                            $resultForQ['awarded'] = $isCorrect ? 1 : 0;
                            $score += $resultForQ['awarded'];
                            break;

                        case QuestionTypeEnum::TrueFalse->value:
                            $selected = (int) ($submitted['selected_answer_id'] ?? 0);
                            $isCorrect = $correctIds->count() === 1 && $correctIds->contains($selected);
                            $resultForQ['correct'] = $isCorrect;
                            $resultForQ['awarded'] = $isCorrect ? 1 : 0;
                            $score += $resultForQ['awarded'];
                            break;

                        case QuestionTypeEnum::MultipleChoiceAndTrueFalse->value:
                            $awarded = 0;

                            $selected = (int) ($submitted['selected_answer_id'] ?? 0);
                            if ($selected && $correctIds->contains($selected)) {
                                $awarded += 0.5;
                            }

                            $bool = Arr::get($submitted, 'bool', null);
                            if ($bool !== null) {
                                $tfCorrect = $q->answers->firstWhere('is_correct', true);
                                if ($tfCorrect) {
                                    $isTrueText = strtolower(trim($tfCorrect->answer_text ?? '')) === 'true';
                                    $isCorrectTF = ($bool === true && $isTrueText) || ($bool === false && !$isTrueText);
                                    if ($isCorrectTF) $awarded += 0.5;
                                }
                            }

                            $resultForQ['correct'] = $awarded === 1.0;
                            $resultForQ['awarded'] = $awarded;
                            $score += $awarded;
                            break;
                    }
                } else {
                    $resultForQ['correct'] = null;
                    $resultForQ['awarded'] = 0;
                }

                $detail[] = $resultForQ;
            }

            $percent = $maxAuto > 0 ? round(($score / $maxAuto) * 100) : 0;

            TestResult::create([
                'test_id'      => $test->id,
                'user_id'      => $request->user()->id,
                'score'        => $percent,
                'passed'       => $percent >= 70,
                'completed_at' => now(),
            ]);


            DB::commit();

            return back()->with([
                'result' => [
                    'score'      => $percent,
                    'passed'     => $percent >= 70,
                    'auto_max'   => $maxAuto,
                    'auto_score' => $score,
                    'detail'     => $detail,
                ],
            ]);
        } catch (Throwable $e) {
            DB::rollBack();
            report($e);
            return back()->withErrors(['submit' => 'Failed to submit test. Please try again.']);
        }
    }
}
