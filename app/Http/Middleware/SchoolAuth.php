<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SchoolAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

public function handle(Request $request, Closure $next): Response
{
    // If not logged in and trying to access any /school route
    if (!session()->has('LoggedSchool') && $request->is('school/*')) {
        return redirect('/users/login')->with('fail', 'You must be logged in');
    }

    // If logged in as school, block login/register pages
    if (
        session()->has('LoggedSchool') &&
        (
            $request->is('users/login') ||
            $request->is('users/register') ||
            $request->is('users/home-page') ||
            $request->routeIs('auth-user-check')
        )
    ) {
        return redirect('/school/dashboard');
    }

    $response = $next($request);

    // Prevent caching
    $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
    $response->headers->set('Pragma', 'no-cache');
    $response->headers->set('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');

    return $response;
}
}
