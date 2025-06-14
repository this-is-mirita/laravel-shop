<?php

namespace App\Providers;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Foundation\Http\Kernel;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Connection;
use Illuminate\Database\Events\QueryExecuted;

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
        // 3 запроса ограницение в минуту по доке
        RateLimiter::for('web', function (Request $request) {
            return Limit::perMinute(50)
                ->by($request->user()?->id ?: $request->ip())
                ->response(function (Request $request, array $headers) {
                    return response('Слишком много запросов', 429, $headers);
                });
        });

        Model::preventLazyLoading(!app()->isProduction());
        Model::preventsSilentlyDiscardingAttributes(!app()->isProduction());
        DB::whenQueryingForLongerThan(CarbonInterval::second(5), function (Connection $connection, QueryExecuted $event) {
            // Notify development team...
            logger()
                ->channel('telegram')
                ->debug('whenQueryingForLongerThan:' . $connection->query()->toSql());
        });

        $kernel = app(Kernel::class);
        $kernel->whenRequestLifecycleIsLongerThan(
            CarbonInterval::second(4), function () {
            logger()
                ->channel('telegram')
                ->debug('whenRequestLifecycleIsLongerThan:' . request()->url());
        });

//        DB::listen(function ($query) {
//            dump($query->sql);
//        });
    }
}
