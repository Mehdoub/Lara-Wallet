<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LocalLanguageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $sentLang = $request->header('accept-language');
        $localLang = $sentLang and in_array($sentLang, ['en', 'fa']) ? $sentLang : 'en';
        app()->setlocale($localLang);

        return $next($request);
    }
}
