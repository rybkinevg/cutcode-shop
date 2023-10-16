<?php

namespace App\Providers;

use App\Http\Kernel;
use App\Logging\Telegram\TelegramLogger;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // composes application behavior during development
        Model::shouldBeStrict(!app()->isProduction());

        //TODO: addition of loggers below will make sense only in production env.

        // long database query execution (milliseconds) handler
        DB::listen(function ($query) {
            if ($query->time > 500) {
                $message = 'Long query execution: ' . $query->sql;

                logger()->channel(TelegramLogger::CHANNEL_NAME)->debug($message);
            }
        });

        // long HTTP query execution handler
        app(Kernel::class)->whenRequestLifecycleIsLongerThan(
            CarbonInterval::seconds(4),
            function ($requestStartedAt, $request, $response) {
                $message = 'whenRequestLifecycleIsLongerThan: ' . $request->url();

                logger()->channel(TelegramLogger::CHANNEL_NAME)->debug($message);
            }
        );
    }
}
