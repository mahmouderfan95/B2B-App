<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class VendorAuth
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse) $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->guard('vendor')->user();

        if ($user) {
            if ($user->banned == 0 && $user->status == 'approved') {
                return $next($request);

            }
            auth()->logout();
        }

        session()->flash('inactive_vendor', __("vendor.inactive"));
        return !$request->fullUrlIs(route("vendor.login")) ? redirect()->route("vendor.login"): $next($request) ;

    }
}
