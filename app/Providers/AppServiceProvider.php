<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        $baseApiUrl = config('app.url');
        View::share('base_api_url', $baseApiUrl);

        // Create a directive that check if a route is active on a blade template
        Blade::directive('isActive', function ($routeName, $activeClass = 'navlink--active') {
            return "<?php echo (request()->routeIs($routeName)) ? '$activeClass' : ''; ?>";
        });
    }
}
