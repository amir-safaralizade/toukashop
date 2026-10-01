<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureCustomerAuthenticated
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->is_guest) {
            $request->session()->put('url.intended', $request->fullUrl());
            return redirect()->route('auth.login-view');
        }

        return $next($request);
    }
}
