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
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    public const VENDORHOME = '/vendor/dashboard/home';
    public const VENDORLOGIN = '/vendor/dashboard/login';


    /**
     * The controller namespace for the application.
     *
     * When present, controller route declarations will automatically be prefixed with this namespace.
     *
     * @var string|null
     */
    // protected $namespace = 'App\\Http\\Controllers';

    protected $vendorNamespace = 'App\\Http\\Controllers\\Vendor';
    protected $shippingNamespace = 'App\\Http\\Controllers\\Shipping';

    protected $subVendorNamespace = 'App\\Http\\Controllers\\SubVendor';


    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::prefix('api')
                ->namespace($this->namespace)
                ->group(base_path('routes/api.php'));

            Route::middleware('web')
                ->namespace($this->namespace)
                ->group(base_path('routes/web.php'));

            Route::prefix('shipping/dashboard')->as('shipping.')
                ->middleware('web')
                ->namespace($this->shippingNamespace)
                ->group(base_path('routes/shipping.php'));

            Route::prefix('vendor/dashboard')->as('vendor.')
                ->middleware('web')
                ->namespace($this->vendorNamespace)
                ->group(base_path('routes/vendor.php'));

            Route::prefix('sub-vendor/dashboard')->as('sub-vendor.')
                ->middleware('web')
                ->namespace($this->subVendorNamespace)
                ->group(base_path('routes/sub-vendor.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by(optional($request->user())->id ?: $request->ip());
        });
    }
}
