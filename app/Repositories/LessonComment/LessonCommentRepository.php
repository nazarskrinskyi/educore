<?php

declare(strict_types=1);

namespace App\Repositories\LessonComment;

use App\Models\LessonComment;

class LessonCommentRepository implements LessonCommentRepositoryInterface
{
    public function isUserHasLessonComment(int $userId, int $lessonId): bool
    {
        return LessonComment::where('user_id', $userId)
            ->when($lessonId, fn($q) => $q->where('lesson_id', $lessonId))
            ->exists();
    }

    public function create(array $data): void
    {
        LessonComment::create($data);
    }

    public function update(array $data, LessonComment $comment): void
    {
        $comment->update($data);
    }

    public function delete(LessonComment $comment): void
    {
        $comment->delete();
    }
}
