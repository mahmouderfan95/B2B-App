<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckBennedClient
{
    public function handle($request, Closure $next)
    {
        if (auth('client')->id() && auth('client')->user()->status != 'accepted') {
            // User is banned, log them out
            auth('client')->logout();
            return response()->json(['message' => trans('api.auth.inactive_client')], 401);
        }

        return $next($request);
    }
}
