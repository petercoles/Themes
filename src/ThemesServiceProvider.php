<?php

namespace PeterColes\Themes;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ThemesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerViewFinder();

        $this->registerThemes();
    }

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/themes.php' => config_path('themes.php'),
        ]);

        $this->app['themes']->setTheme($this->app['request']);

        $this->mapWebRoutes();

        $this->mapApiRoutes();
    }

    /**
     * Re-register the view finder to use use local copy.
     *
     * @return void
     */
    protected function registerViewFinder()
    {
        $this->app['view.finder'] = $this->app->share(function($app) {
            $paths = $app['config']['view.paths'];

            return new FileViewFinder($app['files'], $paths);
        });

        // Apply this finder to the already-registered view factory
        $this->app['view']->setFinder($this->app['view.finder']);
    }

    /**
     * Register the themes service.
     *
     * @return void
     */
    protected function registerThemes()
    {
        $this->app->singleton('themes', function() {
            return new Themes;
        });
    }

    /**
     * Define the "web" routes for the theme.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::group([
            'middleware' => 'web',
            'namespace' => 'App\Http\Controllers',
        ], function ($router) {
            require base_path('themes/'.$this->app['themes']->getTheme().'/routes/web.php');
        });
    }

    /**
     * Define the "api" routes for the theme.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::group([
            'middleware' => ['api', 'auth:api'],
            'namespace' => 'App\Http\Controllers',
            'prefix' => 'api',
        ], function ($router) {
            require base_path('themes/'.$this->app['themes']->getTheme().'routes/api.php');
        });
    }
}
