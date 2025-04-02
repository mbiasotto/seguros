<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckAuthForLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the current path
        $path = $request->path();

        // For vendor area - ONLY redirect if authenticated as vendor
        if (strpos($path, 'vendor') === 0) {
            if (Auth::guard('vendor')->check()) {
                return redirect()->route('vendor.dashboard');
            }

            // DO NOT redirect admin users trying to access vendor area
            // Let them view the vendor login form
        }

        // For admin area - ONLY redirect if authenticated as admin
        if (strpos($path, 'admin') === 0) {
            if (Auth::guard('web')->check()) {
                return redirect()->route('admin.dashboard');
            }

            // DO NOT redirect vendor users trying to access admin area
            // Let them view the admin login form
        }

        return $next($request);
    }
}
