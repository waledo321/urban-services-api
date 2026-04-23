<?php

use App\Support\ApiEnvelope;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ValidationException $exception, Request $request) {
            if (! ApiEnvelope::isApiRequest($request)) {
                return null;
            }

            return ApiEnvelope::error('Validation failed.', $exception->errors(), 422);
        });

        $exceptions->render(function (AuthenticationException $exception, Request $request) {
            if (! ApiEnvelope::isApiRequest($request)) {
                return null;
            }

            $message = $exception->getMessage() !== ''
                ? $exception->getMessage()
                : 'Unauthenticated.';

            return ApiEnvelope::error($message, null, 401);
        });

        $exceptions->render(function (NotFoundHttpException $exception, Request $request) {
            if (! ApiEnvelope::isApiRequest($request)) {
                return null;
            }

            return ApiEnvelope::error(
                'Resource not found.',
                $exception->getMessage() !== '' ? $exception->getMessage() : null,
                404
            );
        });

        $exceptions->render(function (HttpExceptionInterface $exception, Request $request) {
            if (! ApiEnvelope::isApiRequest($request)) {
                return null;
            }

            $message = $exception->getMessage() !== '' ? $exception->getMessage() : 'Request failed.';

            return ApiEnvelope::error($message, null, $exception->getStatusCode());
        });

        $exceptions->render(function (Throwable $exception, Request $request) {
            if (! ApiEnvelope::isApiRequest($request)) {
                return null;
            }

            return ApiEnvelope::error(
                'Internal server error.',
                app()->hasDebugModeEnabled() ? $exception->getMessage() : null,
                500
            );
        });
    })->create();
