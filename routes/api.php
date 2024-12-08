<?php

use App\Enum\PermissionEnum;
use App\Http\Controllers\Api\PermissionApiController;
use App\Http\Controllers\Api\RoleApiController;
use App\Http\Controllers\Api\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function () {
    Route::post('/', [UserApiController::class, 'create'])
        ->name('api.users.create');
});
Route::middleware('auth:web,api')->group(function () {
    // 查看自己是誰
    Route::get('/user', static function (Request $request) {
        return $request->user() ? [
            'status' => true,
            'user' => $request->user(),
        ] : [
            'status' => false
        ];
    });
    Route::prefix('users')->group(function () {
        Route::middleware('permission_api:' . PermissionEnum::ACCOUNT_LIST->value)->group(function () {
            Route::get('/', [UserApiController::class, 'get'])
                ->name('api.users.get');
            Route::get('/all', [UserApiController::class, 'getPage'])
                ->name('api.users.get.all');
        });
        Route::middleware('permission_api:' . PermissionEnum::ACCOUNT_EDIT->value)->group(function () {
            Route::post('/', [UserApiController::class, 'create'])
                ->name('api.users.create');
            Route::put('/', [UserApiController::class, 'update'])
                ->name('api.users.update');
            Route::delete('/', [UserApiController::class, 'delete'])
                ->name('api.users.delete');
        });

    });
    Route::prefix('role')->group(function () {
        Route::middleware('permission_api:' . PermissionEnum::ROLE_LIST->value)->group(function () {
            Route::get('/', [RoleApiController::class, 'get'])
                ->name('api.role.get');
            Route::get('/all', [RoleApiController::class, 'getPage'])
                ->name('api.role.get.all');
        });
        Route::middleware('permission_api:' . PermissionEnum::ROLE_EDIT->value)->group(function () {
            Route::post('/', [RoleApiController::class, 'create'])
                ->name('api.role.create');
            Route::put('/', [RoleApiController::class, 'update'])
                ->name('api.role.update');
            Route::delete('/', [RoleApiController::class, 'delete'])
                ->name('api.role.delete');
        });
    });
    Route::prefix('permission')->group(function () {
        Route::middleware('permission_api:' . PermissionEnum::ROLE_LIST->value)->group(function () {
            Route::get('/', [PermissionApiController::class, 'get'])
                ->name('api.permission.get')
            ;
            Route::get('/all', [PermissionApiController::class, 'getPage'])
                ->name('api.permission.get.all')
            ;
        });
    });
});
