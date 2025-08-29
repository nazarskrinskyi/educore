<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LessonCommentRequest;
use App\Models\LessonComment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LessonCommentController
{
    public function store(LessonCommentRequest $validated): RedirectResponse
    {
        $user = $validated->user();

        $exists = LessonComment::where('user_id', $user->id)
            ->when($validated['lesson_id'] ?? null, fn($q) => $q->where('lesson_id', $validated['lesson_id']))
            ->exists();

        if ($exists) {
            return back()->withErrors(['comment' => 'You already submitted a comment.']);
        }

        $validated['user_id'] = $user->id;

        LessonComment::create(array_filter($validated->all()));

        return back()->with('success', 'comment created successfully');
    }

    public function update(LessonCommentRequest $validated, LessonComment $comment): RedirectResponse
    {
        $comment->update(array_filter($validated->all()));

        return back()->with('success', 'comment updated successfully');
    }

    public function destroy(LessonComment $comment): RedirectResponse
    {
        $comment->delete();

        return back()->with('success', 'comment deleted successfully');
    }
}
