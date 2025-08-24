<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\LessonComment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LessonCommentController
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'lesson_id' => ['nullable', 'integer', 'exists:lessons,id'],
            'comment' => ['nullable', 'string', 'max:255'],
        ]);

        $user = $request->user();

        $exists = LessonComment::where('user_id', $user->id)
            ->when($validated['lesson_id'] ?? null, fn($q) => $q->where('lesson_id', $validated['lesson_id']))
            ->exists();

        if ($exists) {
            return back()->withErrors(['comment' => 'You already submitted a comment.']);
        }

        $validated['user_id'] = $user->id;

        LessonComment::create($validated);

        return back()->with('success', 'comment created successfully');
    }

    public function update(Request $request, LessonComment $comment): RedirectResponse
    {
        $validated = $request->validate([
            'comment' => ['nullable', 'string', 'max:255'],
        ]);

        $comment->update($validated);

        return back()->with('success', 'comment updated successfully');
    }

    public function destroy(LessonComment $comment): RedirectResponse
    {
        $comment->delete();

        return back()->with('success', 'comment deleted successfully');
    }
}
