<?php

namespace Modules\Visit\Services;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class VisitService
{
    public function record(Model $model): void
    {
        $ip = request()->ip();
        $agent = request()->userAgent();
        $userId = Auth::id();

        $alreadyVisited = $model->visits()
            ->where('ip_address', $ip)
            ->where('user_agent', $agent)
            ->where('visited_at', '>=', now()->subSeconds(3))
            ->exists();

        if ($alreadyVisited) return;

        $model->visits()->create([
            'ip_address' => $ip,
            'user_agent' => $agent,
            'user_id' => $userId,
            'visited_at' => now(),
        ]);
    }
}
