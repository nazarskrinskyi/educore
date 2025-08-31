<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LessonCommentRequest;
use App\Models\LessonComment;
use App\Repositories\LessonComment\LessonCommentRepositoryInterface;
use Illuminate\Http\RedirectResponse;

class LessonCommentController extends Controller
{
    public function __construct(private readonly LessonCommentRepositoryInterface $lessonCommentRepository)
    {
    }

    public function store(LessonCommentRequest $validated): RedirectResponse
    {
        $user   = $validated->user();
        $exists = $this->lessonCommentRepository->isUserHasLessonComment($user->id, $validated['lesson_id']);

        if ($exists) {
            return back()->withErrors(['comment' => 'You already submitted a comment.']);
        }

        $validated['user_id'] = $user->id;

        $this->lessonCommentRepository->create(array_filter($validated->all()));

        return back()->with('success', 'comment created successfully');
    }

    public function update(LessonCommentRequest $validated, LessonComment $comment): RedirectResponse
    {
        $this->lessonCommentRepository->update(array_filter($validated->all()), $comment);

        return back()->with('success', 'comment updated successfully');
    }

    public function destroy(LessonComment $comment): RedirectResponse
    {
        $this->lessonCommentRepository->delete($comment);

        return back()->with('success', 'comment deleted successfully');
    }
}
