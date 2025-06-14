<?php

namespace App\Listeners;

use App\Notifications\NewUserNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailNewUser
{
    public function handle(Registered $registered): void
    {
        $registered->user->notify(new NewUserNotification());
    }
}
