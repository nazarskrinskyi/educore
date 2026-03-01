<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Console\Command;

class SendCourseReminders extends Command
{
    protected $signature = 'reminders:telegram';
    protected $description = 'Send daily reminders to students about unfinished courses';

    public function handle(TelegramService $telegram): void
    {
        $users = User::whereNotNull('telegram_chat_id')->get();

        foreach ($users as $user) {
            $unfinishedCourses = $user->courses()
                ->wherePivot('progress_percent', '<', 100)
                ->get();

            if ($unfinishedCourses->count() > 0) {
                $message = "📚 Привіт, $user->name! У вас є незавершені курси на EduCore:\n\n";

                foreach ($unfinishedCourses as $course) {
                    $progress = $course->pivot->progress_percent ?? 0;
                    $message .= "• $course->title ($progress%)\n";
                }

                $message .= "\nПродовжуйте навчання сьогодні 💪";

                $telegram->safeSend($user->telegram_chat_id, $message);
            }
        }

        $this->info('Reminders sent successfully.');
    }
}
