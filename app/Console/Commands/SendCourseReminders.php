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
            $progress = $user->courses()->wherePivot('progress_percent', '<', 100)->count();
            if ($progress > 0) {
                $telegram->safeSend(
                    $user->telegram_chat_id,
                    "📚 Привіт, $user->name! У вас є незавершені курси на EduCore. Продовжуйте навчання сьогодні 💪"
                );
            }
        }

        $this->info('Reminders sent successfully.');
    }
}
