<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $userData = Session::get('api_user_data');

        if (empty($userData)) {
            return redirect('login');
        }

        if (empty($userData['isOwner'])) {
            return redirect('login');
        }

        return $next($request);
    }
}
