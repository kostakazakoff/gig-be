<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Get locale from query parameter, cookie, or header
        $locale = $request->query('locale') 
            ?? $request->cookie('locale')
            ?? $request->header('X-Locale')
            ?? config('app.locale');

        if (in_array($locale, ['en', 'bg'])) {
            app()->setLocale($locale);
        }

        return $next($request);
    }

}
