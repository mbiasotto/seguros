<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class CustomStartSession extends StartSession
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        // Set session cookie name and path based on the request path
        if (Str::startsWith($request->path(), 'vendor')) {
            // For vendor routes, use vendor-specific session
            config([
                'session.cookie' => 'vendor_session',
                'session.path' => '/vendor',  // Restrict cookie to vendor paths
                'session.domain' => null,     // Use current domain only
            ]);
        } else if (Str::startsWith($request->path(), 'admin')) {
            // For admin routes, use admin-specific session
            config([
                'session.cookie' => 'admin_session',
                'session.path' => '/admin',   // Restrict cookie to admin paths
                'session.domain' => null,     // Use current domain only
            ]);
        } else {
            // For all other routes, use default session
            config([
                'session.cookie' => 'laravel_session',
                'session.path' => '/',        // All paths
                'session.domain' => null,     // Use current domain only
            ]);
        }

        // Continue with the standard session handling
        return parent::handle($request, $next);
    }
}
