<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;
use Jenssegers\Agent\Agent;

class IdentifyAnonymousClient
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->is_guest) {
            return $next($request);
        }

        // از اینجا به بعد فقط برای مهمان‌هاست...
        $cookieName = 'anon_client_id';
        $uuid = $request->cookie($cookieName);

        if (!$uuid && session()->has('guest_token')) {
            $uuid = session('guest_token');
            Cookie::queue(cookie($cookieName, $uuid, 60 * 24 * 365));
        }

        if (!$uuid) {
            $uuid = $this->generateToken();
            session(['guest_token' => $uuid]);
            Cookie::queue(cookie($cookieName, $uuid, 60 * 24 * 365));
        }

        $existingRealUser = User::where('guest_token', $uuid)
            ->where('is_guest', false)
            ->first();

        if ($existingRealUser) {
            $uuid = $this->generateToken();
            session(['guest_token' => $uuid]);
            Cookie::queue(cookie($cookieName, $uuid, 5 * 365 * 24 * 60));
        }

        $user = User::firstOrCreate(
            ['guest_token' => $uuid],
            [
                'name' => 'مهمان',
                'email' => 'guest_' . $uuid . '@example.com',
                'password' => bcrypt(Str::random(32)),
                'is_guest' => true,
            ]
        );

        if (!auth()->check()) {
            Auth::login($user);
        }

        $user->update([
            'last_ip' => get_client_ip(),
            'last_agent' => get_user_agent(),
            'last_activity' => now(),
        ]);

        return $next($request);
    }

    protected function generateToken()
    {
        return Str::uuid()->toString() . '-' . uniqid();
    }

}
