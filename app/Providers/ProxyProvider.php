<?php

namespace App\Providers;

use Illuminate\Support\Env;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class ProxyProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // 動態設置協議
        $proxy_schema = Env::get('PROXY_SCHEMA', 'http');
        if (! empty($proxy_schema)) {
            URL::forceScheme($proxy_schema);
        }
    }
}
