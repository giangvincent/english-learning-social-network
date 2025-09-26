<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     */
    public const HOME = '/home';

    /**
     * If specified, this namespace is automatically applied to your controller routes.
     */
    protected $namespace = null;

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::middleware('web')
                ->group(base_path('routes/web.php'));

            $attributes = [
                'middleware' => ['api'],
                'namespace' => 'App\Http\Controllers\API',
            ];

            $apiDomain = config('app.api_domain');

            if (!$apiDomain) {
                $appUrl = config('app.url');
                $host = $appUrl ? parse_url($appUrl, PHP_URL_HOST) : null;

                if ($host) {
                    $apiDomain = str_starts_with($host, 'api.') ? $host : 'api.' . $host;
                }
            }

            if ($apiDomain) {
                $attributes['domain'] = $apiDomain;
            }

            $apiVersion = trim((string) config('app.api_version', 'v1'), '/');

            if ($apiVersion !== '') {
                $attributes['prefix'] = $apiVersion;
            }

            Route::group($attributes, function () {
                require base_path('routes/api.php');
            });
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', function (Request $request): Limit {
            return Limit::perMinute(60)->by((string) ($request->user()?->id ?? $request->ip()));
        });
    }
}
