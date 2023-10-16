<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use App\Services\Telegram\Exceptions\TelegramBotApiException;
use Exception;
use Illuminate\Support\Facades\Http;

class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';

    /**
     * @throws TelegramBotApiException
     */
    public static function sendMessage(string $token, int $chatId, string $message): bool
    {
        $url = sprintf('%s%s/sendMessage', self::HOST, $token);

        $query = ['chat_id' => $chatId, 'text' => $message];

        try {
            $response = Http::get($url, $query)->throw()->json();

            return $response['ok'] ?? false;
        } catch (Exception $e) {
            report(new TelegramBotApiException($e->getMessage()));

            return false;
        }
    }
}
