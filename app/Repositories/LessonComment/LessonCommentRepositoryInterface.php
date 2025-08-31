<?php

declare(strict_types=1);

namespace App\Repositories\LessonComment;

use App\Models\LessonComment;

interface LessonCommentRepositoryInterface
{
    public function isUserHasLessonComment(int $userId, int $lessonId): bool;

    public function create(array $data): void;

    public function update(array $data, LessonComment $comment): void;

    public function delete(LessonComment $comment): void;
}
