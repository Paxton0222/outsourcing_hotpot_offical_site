<?php

namespace App\Http\Middleware;

use App\Enum\PermissionEnum;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionApiCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $perm_key): Response
    {
        if (! $request->user()->hasPermission($perm_key)) {
            return response()->setStatusCode(Response::HTTP_UNAUTHORIZED)->json([
                'status' => false,
                'message' => '禁止訪問',
            ]);
        }

        return $next($request);
    }
}
