<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\HandleInertiaRequests::class,
        ]);

        $middleware->api(prepend: [
            // API middleware can be added here if needed
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->respond(function (\Symfony\Component\HttpFoundation\Response $response, \Throwable $exception, \Illuminate\Http\Request $request) {
            // Handle Inertia requests for error pages
            if ($request->header('X-Inertia') && in_array($response->getStatusCode(), [500, 503, 404, 403])) {
                $page = match ($response->getStatusCode()) {
                    404 => 'Errors/404',
                    403 => 'Errors/403',
                    503 => 'Errors/503',
                    default => 'Errors/500',
                };

                return \Inertia\Inertia::render($page, [
                    'status' => $response->getStatusCode(),
                    'message' => $exception->getMessage() !== '' ? $exception->getMessage() : null,
                ])
                    ->toResponse($request)
                    ->setStatusCode($response->getStatusCode());
            }

            // Handle CSRF token mismatch
            if ($response->getStatusCode() === 419) {
                if ($request->header('X-Inertia')) {
                    return back()->with([
                        'error' => 'The page expired, please try again.',
                    ]);
                }
            }

            return $response;
        });
    })->create();
