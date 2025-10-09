<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Services\TelegramService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTelegramMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int|string $chatId;
    public string $message;

    public function __construct(int|string $chatId, string $message)
    {
        $this->chatId = $chatId;
        $this->message = $message;
    }

    public function handle(TelegramService $telegram): void
    {
        $telegram->safeSend($this->chatId, $this->message);
    }
}
