<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function handle(Request $request, Closure $next): Response
    {

        if (
            !session()->has('LoggedAdmin') &&
            ($request->path() != 'users/login' &&
                $request->path() != 'users/register' &&
                $request->path() != 'users/home-page' &&
                $request->path() != 'users/user-otp' &&
                $request->path() != 'users/public-portal' &&
                !$request->routeIs('auth-user-check') &&
                !$request->routeIs('auth-user-check') &&
                !$request->routeIs('regenerate-otp') &&
                !$request->routeIs('password/reset') &&
                $request->path() != 'users/forgot-password')
        ) {
            Session::put('url.intended', $request->url());

            // return redirect('/users/login')->with('fail', 'You must be logged in');
            return redirect('/users/home-page')->with('fail', 'You must be logged in');

        }

        if (
            session()->has('LoggedStudent') &&
            ($request->path() == 'users/login' || $request->path() == 'users/register' || $request->path() == 'users/home-page' || $request->routeIs('auth-user-check'))
        ) {
            return redirect('/student/dashboard');
        }

        if (
            session()->has('LoggedAdmin') &&
            ($request->path() == 'users/login' || $request->path() == 'users/register' || $request->path() == 'users/home-page' || $request->routeIs('auth-user-check'))
        ) {
            return redirect('/');
        }

        if (
            session()->has('LoggedSchool') &&
            (
                $request->path() == 'users/login' ||
                $request->path() == 'users/register' ||
                $request->path() == 'users/home-page' ||
                $request->routeIs('auth-user-check')
            )
        ) {
            return redirect('/school/dashboard');
        }

        $response = $next($request);

        $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');

        return $response;
    }
}
