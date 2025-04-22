<?php

namespace App\Http\Middleware;

use App\Models\Language;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class setClientLocal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $lang = $request->header('lang')??'ar';
        app()->setLocale($lang);
        if( session('lang_code' ) != $lang)
        {
            $lang_id = Language::where('code',$lang)->first()?->id?? Language::first()?->id ;
            session(['client_lang' => $lang_id,
                     "lang_code"    => $lang ]);
        }

        return $next($request);

    }
}
