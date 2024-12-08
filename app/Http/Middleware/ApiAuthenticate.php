<?php

namespace App\Http\Middleware;

use App\Http\Requests\Traits\ApiResponse;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

class ApiAuthenticate
{
    use ApiResponse;

    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): \Inertia\Response|JsonResponse
    {
        if (! Auth::guard('api')->check() && ! Auth::guard('web')->check()) {
            $this->failedAuthorization();
        }

        return $next($request);
    }
}
