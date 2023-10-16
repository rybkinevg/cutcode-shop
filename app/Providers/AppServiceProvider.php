<?php

namespace App\Providers;

use App\Http\Kernel;
use App\Logging\Telegram\TelegramLogger;
use Carbon\CarbonInterval;
use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(!app()->isProduction());
        Model::preventSilentlyDiscardingAttributes(!app()->isProduction());

        //TODO: addition of loggers below will make sense only in production env.

        // long database connection handler
        DB::whenQueryingForLongerThan(500, function (Connection $connection, QueryExecuted $event) {
            $message = 'whenQueryingForLongerThan: ' . $connection->query()->toSql();

            logger()->channel(TelegramLogger::CHANNEL_NAME)->debug($message);
        });

        // long database query execution (milliseconds) handler
        DB::listen(function ($query) {
            if ($query->time > 500) {
                $message = 'Long query execution: ' . $query->sql;

                logger()->channel(TelegramLogger::CHANNEL_NAME)->debug($message);
            }
        });

        /** @var Kernel $kernel */
        $kernel = app(Kernel::class);

        // long HTTP query execution handler
        $kernel->whenRequestLifecycleIsLongerThan(
            CarbonInterval::seconds(4),
            function ($requestStartedAt, $request, $response) {
                $message = 'whenRequestLifecycleIsLongerThan: ' . $request->url();

                logger()->channel(TelegramLogger::CHANNEL_NAME)->debug($message);
            }
        );
    }
}
