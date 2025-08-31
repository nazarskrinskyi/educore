<?php

namespace App\Http\Controllers;

use App\Http\Requests\TestSaveProgressRequest;
use App\Http\Requests\TestSubmitRequest;
use App\Http\Resources\TestResource;
use App\Models\Test;
use App\Repositories\Test\TestRepositoryInterface;
use App\Services\TestService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;
use Throwable;

class TestController extends Controller
{
    public function __construct(
        private readonly TestService $testService,
        private readonly TestRepositoryInterface $testRepository
    ) {
    }

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
        $attempt = $this->testRepository->getOneNotCompletedWithAnswersByUserIdAndTestId(
            auth()->id(),
            $test->id
        );

        if (!$attempt) {
            return response()->json(null);
        }

        return response()->json($attempt);
    }

    public function saveProgress(TestSaveProgressRequest $data, Test $test): void
    {
        $attempt = $this->testRepository->createAttempt(auth()->id(), $test->id);

        if (isset($data['elapsed_seconds'])) {
            $attempt->elapsed_seconds = $data['elapsed_seconds'];
        }

        if (!empty($data['is_completed'])) {
            $attempt->is_completed = true;
        }

        $attempt->save();

        $this->testService->saveAttempt($data->all(), $attempt);
    }

    public function submit(TestSubmitRequest $request, Test $test): RedirectResponse
    {
        try {
            $test->load('questions.answers');

            $this->testService->submit($test, $request->input('answers'), auth()->id());

            return redirect()->route('test.result', ['test' => $test->id]);
        } catch (Throwable $e) {
            report($e);
            return back()->withErrors(['submit' => 'Failed to submit test. Please try again.']);
        }
    }

    public function result(Test $test): Response|RedirectResponse
    {
        $result = $this->testRepository->getUserTestResult(auth()->id(), $test->id);

        $test->load('questions.answers');

        return Inertia::render('Tests/Result', [
            'test' => $test,
            'result' => $result,
            'detail' => $result->details ?? [],
        ]);
    }
}
