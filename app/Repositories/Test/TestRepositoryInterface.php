<?php

declare(strict_types=1);

namespace App\Repositories\Test;

use App\Models\TestAttempt;
use App\Models\TestAttemptAnswer;
use App\Models\TestResult;

interface TestRepositoryInterface
{
    public function getOneNotCompletedWithAnswersByUserIdAndTestId(int $userId, int $testId): ?TestAttempt;
    public function createAttempt(int $userId, int $testId): TestAttempt;
    public function getUserTestResult(int $userId, int $testId): ?TestResult;
    public function createOrUpdateTestAttempt(TestAttempt $attempt, array $data): TestAttemptAnswer;
    public function createOrUpdateTestResult(int $userId, int $testId, array $data): void;
    public function deleteTestAttemptByUserIdAndTestId(int $userId, int $testId): void;
}
