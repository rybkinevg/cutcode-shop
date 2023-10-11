<?php

declare(strict_types=1);

namespace App\Services\Telegram;

use Exception;
use Illuminate\Support\Facades\Http;

class TelegramBotApi
{
    public const HOST = 'https://api.telegram.org/bot';

    public static function sendMessage(string $token, int $chatId, string $message): bool
    {
        $url = sprintf('%s%s/sendMessage', self::HOST, $token);

        $query = ['chat_id' => $chatId, 'text' => $message];

        try {
            Http::get($url, $query);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}
