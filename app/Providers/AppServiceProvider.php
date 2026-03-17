<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

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
        if (app()->environment('production')) {
            $appUrl = (string) config('app.url');

            if ($appUrl !== '') {
                if (! preg_match('/^https?:\/\//i', $appUrl)) {
                    $appUrl = 'https://'.$appUrl;
                } else {
                    $appUrl = preg_replace('/^http:\/\//i', 'https://', $appUrl) ?? $appUrl;
                }

                config(['app.url' => $appUrl]);
                URL::forceRootUrl($appUrl);
                URL::forceScheme('https');
            }
        }

        // Railway can boot before the sessions table exists. Fall back to
        // cookie sessions so the app stays usable until migrations run.
        if (config('session.driver') !== 'database') {
            return;
        }

        try {
            if (! Schema::hasTable(config('session.table', 'sessions'))) {
                config(['session.driver' => env('SESSION_FALLBACK_DRIVER', 'cookie')]);
            }
        } catch (\Throwable $e) {
            config(['session.driver' => env('SESSION_FALLBACK_DRIVER', 'cookie')]);
        }
    }
}
