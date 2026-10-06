<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // บังคับใช้ HTTPS เฉพาะเมื่อรันบน Server จริง (ไม่ใช่ localhost / 127.0.0.1)
        if (!app()->runningInConsole()) {
            $host = request()->getHost();
            $isLocal = in_array($host, ['localhost', '127.0.0.1', '::1'], true);

            if (!$isLocal && (config('app.env') === 'production' || request()->server('HTTP_X_FORWARDED_PROTO') === 'https')) {
                \Illuminate\Support\Facades\URL::forceScheme('https');
            }
        }
    }
}
