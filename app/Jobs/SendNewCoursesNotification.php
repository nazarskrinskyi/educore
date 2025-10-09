<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\User;
use App\Models\Course;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendNewCoursesNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle(): void
    {
        $users = User::whereNotNull('telegram_chat_id')->get();
        $newCourses = Course::where('created_at', '>=', now()->subDay())->get();

        Log::info("Sending new courses notification to {$users->count()} users. Found {$newCourses->count()} new courses.");

        if ($newCourses->isEmpty()) return;

        foreach ($users as $user) {
            $user->load('courses');
            $userCourses = $user->courses->pluck('id')->toArray();

            $message = "🎓 Привіт, $user->name!\n";
            $message .= "Нові курси доступні на EduCore:\n";
            foreach ($newCourses as $course) {
                if (!in_array($course->id, $userCourses)) {
                    $message .= "• $course->title\n";
                }
            }

            SendTelegramMessage::dispatch($user->telegram_chat_id, $message);
        }
    }
}
