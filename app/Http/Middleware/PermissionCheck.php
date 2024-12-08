<?php

namespace App\Http\Middleware;

use App\Enum\PermissionEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $perm_key): Response
    {
        if (! $request->user()->hasPermission($perm_key)) {
            abort(Response::HTTP_UNAUTHORIZED, '禁止授權訪問');
        }

        return $next($request);
    }
}
