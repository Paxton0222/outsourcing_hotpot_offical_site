<?php

namespace App\Http\Middleware;

use App\Enum\PermissionEnum;
use App\Http\Requests\Traits\ResponseMessage;
use Diglactic\Breadcrumbs\Breadcrumbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    use ResponseMessage;
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $user = $request->user();
        $super_user = $user && !$user->isSuperUser();
        $account_list = $user && !$user->hasPermission(PermissionEnum::ACCOUNT_LIST->value);
        $role_list = $user && !$user->hasPermission(PermissionEnum::ROLE_LIST->value);

        return [
            ...parent::share($request),
            'breadcrumbs' => Breadcrumbs::generate(),
            'error_messages' => $this->frontendMessages(),
            'csrf_token' => csrf_token(),
            'menu' => [
                [
                    'href' => 'index',
                    'name' => '首頁',
                    'icon' => 'home',
                ],
                [
                    'href' => 'dashboard',
                    'name' => '後台首頁',
                    'icon' => 'monitor',
                ],
                [
                    'href' => 'profile.edit',
                    'name' => '帳戶設定',
                    'icon' => 'Person',
                ],
                [
                    'name' => '用戶管理',
                    'icon' => 'manage_accounts',
                    'hide' => $account_list,
                    'sub' => [
                        [
                            'href' => 'user.edit',
                            'name' => '用戶列表',
                            'icon' => 'groups',
                            'hide' => $account_list,
                        ],
                        [
                            'href' => 'role.edit',
                            'name' => '角色列表',
                            'icon' => 'group_add',
                            'hide' => $role_list,
                        ],
                    ],
                ],
                [
                    'name' => '系統資訊',
                    'hide' => $super_user,
                    'icon' => 'monitoring',
                    'sub' => [
                        [
                            'name' => 'Horizon',
                            'hide' => $super_user,
                            'href' => 'system-monitor.horizon',
                            'icon' => 'work',
                        ],
                        [
                            'name' => 'Telescope',
                            'hide' => $super_user,
                            'href' => 'system-monitor.telescope',
                            'icon' => 'analytics',
                        ],
                    ],
                ],
            ],
            'auth' => [
                'user' => $user,
                'isLogin' => Auth::check(),
                'canLogin' => Route::has('login'),
                'canRegister' => Route::has('register'),
            ],
        ];
    }
}
