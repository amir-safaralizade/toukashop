<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Jenssegers\Agent\Agent;
use Spatie\Activitylog\Models\Activity;

class LogSuccessfulLogin
{
    public function handle(Login $event)
    {
        activity()
            ->causedBy($event->user)
            ->withProperties([
                'ip_address' => get_client_ip(),
                'user_agent' => get_user_agent(),
                'email' => $event->user->email,
                'guard' => $event->guard,
            ])
            ->log("ورود موفق به سیستم (Guard: {$event->guard})");

        auth()->user()->update([
            'last_login' => now(),
            'last_login_ip' => get_client_ip(),
            'last_login_agent' => get_user_agent(),
        ]);
    }
}
