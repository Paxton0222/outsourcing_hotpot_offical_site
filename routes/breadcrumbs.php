<?php

use Diglactic\Breadcrumbs\Breadcrumbs;
use Diglactic\Breadcrumbs\Generator as BreadcrumbTrail;

Breadcrumbs::for('index', static function (BreadcrumbTrail $trail) {
    $trail->push('首頁', route('index', request()->query(), false));
});

Breadcrumbs::for('register', static function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('註冊', route('register', request()->query(), false));
});
Breadcrumbs::for('login', static function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('登入', route('login', request()->query(), false));
});
Breadcrumbs::for('password.request', static function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('忘記密碼', route('password.request', request()->query(), false));
});

Breadcrumbs::for('dashboard', static function (BreadcrumbTrail $trail) {
    $trail->push('後台首頁', route('dashboard', request()->query(), false));
});

Breadcrumbs::for('verification.notice', static function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('需要電子郵件驗證', route('verification.notice', request()->query(), false));
});
Breadcrumbs::for('password.confirm', static function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('需要密碼驗證', route('password.confirm', request()->query(), false));
});

Breadcrumbs::for('profile.edit', static function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('帳戶設定', route('profile.edit', request()->query(), false));
});

Breadcrumbs::for('user', static function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('用戶管理');
});
Breadcrumbs::for('user.edit', static function (BreadcrumbTrail $trail) {
    $trail->parent('user');
    $trail->push('用戶列表', route('user.edit', request()->query(), false));
});
Breadcrumbs::for('role.edit', static function (BreadcrumbTrail $trail) {
    $trail->parent('user');
    $trail->push('角色列表', route('role.edit', request()->query(), false));
});

Breadcrumbs::for('system', static function (BreadcrumbTrail $trail) {
    $trail->parent('dashboard');
    $trail->push('系統資訊');
});
Breadcrumbs::for('system-monitor.horizon', static function (BreadcrumbTrail $trail) {
    $trail->parent('system');
    $trail->push('Horizon', route('system-monitor.horizon', request()->query(), false));
});
Breadcrumbs::for('horizon.index', static function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('horizon', route('horizon.index', request()->query(), false));
});
Breadcrumbs::for('system-monitor.telescope', static function (BreadcrumbTrail $trail) {
    $trail->parent('system');
    $trail->push('Telescope', route('system-monitor.telescope', request()->query(), false));
});
Breadcrumbs::for('telescope', static function (BreadcrumbTrail $trail) {
    $trail->parent('index');
    $trail->push('telescope', route('telescope', request()->query(), false));
});
