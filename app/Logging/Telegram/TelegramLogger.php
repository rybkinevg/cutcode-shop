<?php

declare(strict_types=1);

namespace App\Logging\Telegram;

use Monolog\Logger;

class TelegramLogger
{
    public const CHANNEL_NAME = 'telegram';

    public function __invoke(array $config): Logger
    {
        $logger = new Logger(self::CHANNEL_NAME);

        $logger->pushHandler(new TelegramLoggerHandler($config));

        return $logger;
    }
}
