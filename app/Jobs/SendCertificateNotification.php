<?php

declare(strict_types=1);


namespace App\Jobs;

use App\Models\Certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendCertificateNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Certificate $certificate;

    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    public function handle(): void
    {
        $user = $this->certificate->user;
        if (!$user || !$user->telegram_chat_id) return;

        $message = "🏆 Вітаємо, $user->name!\n";
        $message .= "Ви отримали сертифікат для курсу: {$this->certificate->course->title}!\n";
        $message .= "Переглянути сертифікат: " . route('certificates.show', $this->certificate->id);

        SendTelegramMessage::dispatch($user->telegram_chat_id, $message);
    }
}
