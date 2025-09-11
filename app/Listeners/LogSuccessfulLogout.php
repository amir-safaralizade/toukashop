<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use Jenssegers\Agent\Agent;
use Spatie\Activitylog\Models\Activity;

class LogSuccessfulLogout
{
    public function handle(Logout $event)
    {
        activity()
            ->causedBy($event->user)
            ->withProperties([
                'ip_address' => get_client_ip(),
                'user_agent' => get_user_agent(),
                'email' => $event->user->email,
                'guard' => $event->guard,
            ])
            ->log("خروج موفق از سیستم (Guard: {$event->guard})");
    }
}
