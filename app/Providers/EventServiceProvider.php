<?php

namespace App\Providers;

use App\Listeners\SendEmailNewUser;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Registered;
class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Registered::class => [
            SendEmailNewUser::class,
        ],
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
