<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $response = $next($request);
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('Content-Security-Policy', "default-src 'self'; script-src 'self'; style-src 'self'; object-src 'none'");
        $response->headers->set('X-Content-Type-Options', 'nosniff');
        // Set the HSTS header with a max age of 1 year (31536000 seconds)
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');
        $response->headers->set('Allow', 'GET, POST, PUT, DELETE');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}
