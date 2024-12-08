<?php

use App\Http\Middleware\ApiAuthenticate;
use App\Http\Middleware\HandleInertiaRequests;
use App\Http\Middleware\PermissionApiCheck;
use App\Http\Middleware\PermissionCheck;
use App\Http\Middleware\RedirectUrlMiddleware;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->web(
            append: [
                RedirectUrlMiddleware::class,
                HandleInertiaRequests::class,
                AddLinkHeadersForPreloadedAssets::class,
            ],
        );
        $middleware->api(
            append: [
                'throttle:120,1',
                SubstituteBindings::class,
            ],
        );

        $middleware->group('auth:web,api', []);
        $middleware->appendToGroup('auth:web,api', [
            'throttle:120,1',
            SubstituteBindings::class,
        ]);
        $middleware->prependToGroup('auth:web,api', [
            EncryptCookies::class,
            AddQueuedCookiesToResponse::class,
            StartSession::class,
            ApiAuthenticate::class,
        ]);
        $middleware->alias([
            'permission' => PermissionCheck::class,
            'permission_api' => PermissionApiCheck::class,
        ]);
    })
    ->withExceptions(static function (Exceptions $exceptions) {
        $exceptions->respond(function (Response $response, Throwable $exception, Request $request) {
            if (! app()->environment(['local', 'testing']) && in_array($response->getStatusCode(), [500, 503, 404, 403], true)) {
                //                return \Illuminate\Support\Facades\Redirect::to(route('error', [
                //                    'status' => $response->getStatusCode(),
                //                ]));
                return Inertia::render('Error', [
                    'status' => $response->getStatusCode(),
                ])
                    ->toResponse($request)
                    ->setStatusCode($response->getStatusCode())
                    ;
            }

            if ($response->getStatusCode() === 419) {
                return Redirect::to(route('login'))->with([
                    'message' => '頁面已經過期，請重新登入',
                ]);
            }

            return $response;
        });
    })->create()
    ;
