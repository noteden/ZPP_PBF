<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackLastSeen
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        // Zapisujemy najwyżej raz na minutę, by nie zalewać bazy zapytaniami.
        if ($user && (
            $user->last_seen_at === null ||
            $user->last_seen_at->lt(now()->subMinute())
        )) {
            User::whereKey($user->id)->update(['last_seen_at' => now()]);
        }

        return $next($request);
    }
}
