<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth('client')->user() && auth('client')->user()->status == 'accepted'){
            return $next($request);
        }
        return  response()->json([
            "success" =>false,
            "status" => 401,
            "data" => [],
            "message" => __('front.login.unauthorized'),
        ], 401);
    }
}
