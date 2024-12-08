<?php

use App\Enum\PermissionEnum;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SystemMonitor;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', static function () {
    return Inertia::render('WelcomePage');
})->name('index');

Route::get('/dashboard', static function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('user')->group(function () {
        Route::middleware('permission:' . PermissionEnum::ACCOUNT_LIST->value)->group(function () {
            Route::get('/', [UserController::class, 'edit'])->name('user.edit');
        });
        Route::middleware('permission:' . PermissionEnum::ACCOUNT_EDIT->value)->group(function () {
            Route::post('/', [UserController::class, 'create'])->name('user.create');
            Route::put('/', [UserController::class, 'update'])->name('user.update');
            Route::delete('/', [UserController::class, 'delete'])->name('user.delete');
        });
    });

    Route::prefix('role')->group(function () {
        Route::middleware('permission:' . PermissionEnum::ROLE_LIST->value)->group(function () {
            Route::get('/', [RoleController::class, 'edit'])->name('role.edit');
        });
        Route::middleware('permission:' . PermissionEnum::ROLE_EDIT->value)->group(function () {
            Route::post('/', [RoleController::class, 'create'])->name('role.create');
            Route::put('/', [RoleController::class, 'update'])->name('role.update');
            Route::delete('/', [RoleController::class, 'delete'])->name('role.delete');
        });
    });

    Route::prefix('system-monitor')->group(static function () {
        Route::get('/horizon', [SystemMonitor::class, 'horizon'])->name('system-monitor.horizon');
        Route::get('/telescope', [SystemMonitor::class, 'telescope'])->name('system-monitor.telescope');
    });
});

require __DIR__ . '/auth.php';
