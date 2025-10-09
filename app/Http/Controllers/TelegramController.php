<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use App\Services\TelegramService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

final class TelegramController extends Controller
{
    public function __construct(
        private readonly TelegramService $telegram
    ) {}

    /**
     * Handle Telegram webhook updates.
     */
    public function webhook(Request $request): JsonResponse
    {
        $update = $request->json()->all();
        Log::info('📩 Incoming Telegram update', $update);

        $message = $update['message'] ?? null;
        if (!$message) {
            return response()->json(['ok' => true]);
        }

        $chatId = data_get($message, 'chat.id');
        $text   = trim((string) data_get($message, 'text', ''));

        try {
            return $this->handleMessage($chatId, $text);
        } catch (Throwable $e) {
            Log::error('Telegram webhook failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->telegram->safeSend($chatId, '⚠️ Сталася помилка. Спробуйте пізніше.');

            return response()->json(['ok' => false, 'error' => $e->getMessage()]);
        }
    }

    /**
     * Core message handler.
     */
    private function handleMessage(int|string $chatId, string $text): JsonResponse
    {
        // Простий масив команд для DRY
        $commands = [
            '/start'    => fn() => $this->sendStartMessage($chatId),
            '/courses'  => fn() => $this->sendCoursesList($chatId),
            '/progress' => fn() => $this->sendUserProgress($chatId),
            '/help'     => fn() => $this->sendHelpMessage($chatId),
        ];

        // Виконуємо команду якщо вона існує
        if (isset($commands[$text])) {
            $commands[$text]();
            return response()->json(['ok' => true]);
        }

        // Прив’язка акаунта за email
        if (filter_var($text, FILTER_VALIDATE_EMAIL)) {
            return $this->bindTelegramByEmail($chatId, $text);
        }

        // За замовчуванням — невідома команда
        $this->telegram->safeSend(
            $chatId,
            "🤖 Невідома команда.\n\nДоступні команди:\n/start — почати роботу\n/help — довідка"
        );

        return response()->json(['ok' => true]);
    }

    private function sendStartMessage(int|string $chatId): void
    {
        $this->telegram->safeSend(
            $chatId,
            "👋 Вітаємо в <b>EduCore</b>!\n\nБудь ласка, введіть ваш email, щоб ми могли прив’язати ваш акаунт."
        );
    }

    private function sendCoursesList(int|string $chatId): void
    {
        $courses = Course::where('is_published', true)->pluck('title');
        $message = "🎓 Доступні курси:\n" . $courses->map(fn($title) => "• $title")->implode("\n");
        $this->telegram->safeSend($chatId, $message);
    }

    private function sendUserProgress(int|string $chatId): void
    {
        $user = User::where('telegram_chat_id', $chatId)->first();
        if (!$user) {
            $this->telegram->safeSend($chatId, '❌ Користувача не знайдено.');
            return;
        }

        $progressLines = $user->courses->map(
            fn($course) => "• $course->title: {$course->pivot->progress_percent}%"
        );

        $message = "📊 Ваш прогрес:\n" . $progressLines->implode("\n");
        $this->telegram->safeSend($chatId, $message);
    }

    private function sendHelpMessage(int|string $chatId): void
    {
        $this->telegram->safeSend(
            $chatId,
            "🤖 Команди бота EduCore:\n" .
            "/start — Прив’язати акаунт\n" .
            "/progress — Ваш прогрес у курсах\n" .
            "/courses — Список доступних курсів\n" .
            "/help — Допомога"
        );
    }

    private function bindTelegramByEmail(int|string $chatId, string $email): JsonResponse
    {
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->telegram->safeSend($chatId, '❌ Користувача з таким email не знайдено.');
            return response()->json(['ok' => true]);
        }

        $user->update(['telegram_chat_id' => $chatId]);
        $this->telegram->safeSend($chatId, "✅ Ваш Telegram успішно прив’язано до акаунта EduCore!");

        return response()->json(['ok' => true]);
    }
}
