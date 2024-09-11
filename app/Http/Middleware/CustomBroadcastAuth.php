<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomBroadcastAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($this->checkExternalAuth($request)) {
            return $next($request);
        }

        return response('Unauthorized.', 403);
    }

    private function checkExternalAuth($request)
    {
        return true; // should be always true
    }
}
