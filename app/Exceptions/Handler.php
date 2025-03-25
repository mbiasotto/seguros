<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Throwable;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Illuminate\Support\Facades\Route;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        Log::info('Request Path: ' . $request->path());
        Log::error('Exception Message: ' . $e->getMessage());

        if ($e instanceof RouteNotFoundException) {
            if (strpos($request->path(), 'admin') === 0) {
                return redirect()->route('admin.login');
            }
        }

        return parent::render($request, $e);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        if ($request->expectsJson()) {
            return response()->json(['error' => 'Unauthenticated.'], 401);
        }

        $guard = data_get($exception->guards(), 0);

        switch ($guard) {
            case 'vendor':
                return redirect()->route('vendor.login');
            case 'web':
            default:
                if ($request->is('vendor/*') || $request->is('vendor')) {
                    return redirect()->route('vendor.login');
                }
                return redirect()->route('admin.login');
        }
    }
}
