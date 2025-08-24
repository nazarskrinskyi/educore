<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LessonCompletionController extends Controller
{
    public function toggle(Request $request, Lesson $lesson): RedirectResponse
    {
        $user = $request->user();

        $completed = $user->lessons()
            ->where('lesson_id', $lesson->id)
            ->exists();

        $completed ?
            $user->lessons()->detach($lesson->id) :
            $user->lessons()->attach($lesson->id, ['completed_at' => now()]);

        return back();
    }

    public function complete(Request $request, Lesson $lesson): JsonResponse
    {
        $user = $request->user();

        $user->lessons()->syncWithoutDetaching([
            $lesson->id => ['completed_at' => now()]
        ]);

        return response()->json(['status' => 'completed']);
    }
}
