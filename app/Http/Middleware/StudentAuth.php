<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Session;
use Symfony\Component\HttpFoundation\Response;

class StudentAuth
{
    /**
     * Route names a restricted "marks entrant" admin account is allowed
     * to reach. Everything else under this middleware (which gates
     * virtually every admin-side page today) is off-limits to them.
     */
    private const MARKS_ENTRANT_ALLOWED_ROUTES = [
        'enter.marks',
        'class.allocation.filter',
        'iteb.save.marks',
        'iteb.get.marks',
        'iteb.get.subject.marks',
        'search.iteb.students',
        'notifications.inbox',
        'notifications.inbox.read',
    ];

    private const MARKS_ENTRANT_ALLOWED_PATHS = [
        'enter-marks',
        'class-allocation',
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    
    public function handle(Request $request, Closure $next): Response
    {

        if (!session()->has('LoggedStudent')) {
            Session::put('url.intended', $request->url());
            return redirect('/users/login')->with('fail', 'You must be logged in');
        }

        if (session()->has('LoggedStudent') && ($request->path() == 'users/login' || $request->path() == 'users/register' || $request->routeIs('auth-user-check'))) {
            
            return redirect('/student/dashboard');
        }

        if (session()->has('LoggedAdmin') && $this->isRestrictedMarksEntrant()) {
            $routeName = $request->route() ? $request->route()->getName() : null;

            $allowed = in_array($routeName, self::MARKS_ENTRANT_ALLOWED_ROUTES, true)
                || in_array($request->path(), self::MARKS_ENTRANT_ALLOWED_PATHS, true);

            if (!$allowed) {
                return redirect('/enter-marks')->with('fail', 'You do not have access to that section.');
            }
        }

        $response = $next($request);

        $response->headers->set('Cache-Control', 'no-cache, no-store, max-age=0, must-revalidate');
        $response->headers->set('Pragma', 'no-cache');
        $response->headers->set('Expires', 'Sat, 01 Jan 1990 00:00:00 GMT');

        return $response;
    }

    private function isRestrictedMarksEntrant(): bool
    {
        $user = User::find(session('LoggedAdmin'));

        return $user ? $user->isMarksEntrant() : false;
    }
}