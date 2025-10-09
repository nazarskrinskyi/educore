<?php

namespace App\Services;

use Exception;
use TelegramBot\Api\BotApi;
use Illuminate\Support\Facades\Log;
use Throwable;

final class TelegramService
{
    private BotApi $bot;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->bot = new BotApi(config('services.telegram.token'));
    }

    /**
     * Send message with full control (throws exceptions).
     * @throws Throwable
     */
    public function send(int|string $chatId, string $message, string $parseMode = 'HTML'): void
    {
        $this->bot->sendMessage($chatId, $message, $parseMode);
    }

    /**
     * Safe wrapper — logs errors instead of throwing.
     */
    public function safeSend(int|string $chatId, string $message): void
    {
        try {
            $this->send($chatId, $message);
        } catch (Throwable $e) {
            Log::error('Telegram send failed', [
                'chat_id' => $chatId,
                'error' => $e->getMessage(),
            ]);
        }
    }
}
