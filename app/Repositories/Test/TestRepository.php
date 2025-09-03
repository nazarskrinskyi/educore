<?php

declare(strict_types=1);

namespace App\Repositories\Test;

use App\Models\TestAttempt;
use App\Models\TestAttemptAnswer;
use App\Models\TestResult;

class TestRepository implements TestRepositoryInterface
{
    public function getOneNotCompletedWithAnswersByUserIdAndTestId(int $userId, int $testId): ?TestAttempt
    {
        return TestAttempt::with('answers')
            ->where('user_id', $userId)
            ->where('test_id', $testId)
            ->where('is_completed', false)
            ->first();
    }

    public function createAttempt(int $userId, int $testId): TestAttempt
    {
        return TestAttempt::firstOrCreate(
            ['user_id' => $userId, 'test_id' => $testId, 'is_completed' => false],
            ['elapsed_seconds' => 0]
        );
    }

    public function getUserTestResult(int $userId, int $testId): ?TestResult
    {
        return TestResult::where('test_id', $testId)
            ->where('user_id', $userId)
            ->firstOrFail();
    }

    public function createOrUpdateTestAttempt(TestAttempt $attempt, array $data): TestAttemptAnswer
    {
        return $attempt->answers()->updateOrCreate(
            ['question_id' => $data['question_id']],
            [
                'selected_answer_id' => $data['selected_answer_id'] ?? null,
                'selected_answer_ids' => isset($data['selected_answer_ids']) ? json_encode($data['selected_answer_ids']) : null,
                'bool' => $data['bool'] ?? null,
                'text' => $data['text'] ?? null,
            ]
        );
    }

    public function createOrUpdateTestResult(int $userId, int $testId, array $data): void
    {
        TestResult::updateOrCreate(
            [
                'test_id' => $testId,
                'user_id' => $userId,
            ],
            $data
        );
    }

    public function deleteTestAttemptByUserIdAndTestId(int $userId, int $testId): void
    {
        TestAttempt::where([
            'test_id' => $testId,
            'user_id' => $userId,
        ])->delete();
    }
}
