<?php

declare(strict_types=1);

namespace App\Repositories\Test;

use App\Models\TestAttempt;
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
}
