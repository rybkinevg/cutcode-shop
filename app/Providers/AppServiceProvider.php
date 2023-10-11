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

        DB::whenQueryingForLongerThan(500, function (Connection $connection, QueryExecuted $event) {
            $message = 'whenQueryingForLongerThan: ' . $connection->query()->toSql();

            logger()->channel(TelegramLogger::CHANNEL_NAME)->debug($message);
        });

        $kernel = app(Kernel::class);

        $kernel->whenRequestLifecycleIsLongerThan(
            CarbonInterval::seconds(4),
            fn() => logger()->channel(TelegramLogger::CHANNEL_NAME)->debug(
                'whenRequestLifecycleIsLongerThan: ' . request()->url()
            )
        );
    }
}
