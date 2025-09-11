<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Auth\Events\Failed;
use Jenssegers\Agent\Agent;

class LogFailedLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Failed $event)
    {
        $properties = [
            'ip_address' => get_client_ip(),
            'user_agent' => get_user_agent(),
            'guard' => $event->guard,
        ];

        if ($event->user) {
            $properties['email'] = $event->user->email;
            $properties['username'] = $event->user->username;
        }

        activity()
            ->withProperties($properties)
            ->log("تلاش ناموفق برای ورود به سیستم (Guard: {$event->guard})");
    }
}
