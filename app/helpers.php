<?php

use Illuminate\Support\Facades\Auth;

/**
 * 依照字串中的逗號把資料分離成array並返回.
 */
function extractByCommas(?string $data): array
{
    return explode(',', $data);
}

/**
 * 取得已啟用的 guard ，都沒有啟用返回默認
 */
function activeGuard(): string
{
    foreach (array_keys(config('auth.guards')) as $guard) {
        if (auth()->guard($guard)->check()) {
            return $guard;
        }
    }

    return Auth::getDefaultDriver();
}

function checkAndSetPageParameters($request, $page = 1, $perPage = 9, $search = []): array
{
    $page = $request->get('page', $page);
    $prePage = $request->get('perPage', $perPage);
    $search = $request->get('search', $search);
    $asc = $request->get('asc', []);
    $desc = $request->get('desc', []);

    return [
        $page,
        $prePage,
        $search,
        $asc,
        $desc,
    ];
}
