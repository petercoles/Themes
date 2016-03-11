<?php

namespace Themes;

use Illuminate\Support\ServiceProvider;

class ThemesServiceProvider extends ServiceProvider
{
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
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app['view.finder'] = $this->app->share(function($app) {
            $paths = $app['config']['view.paths'];

            return new FileViewFinder($app['files'], $paths);
        });

        $this->app->singleton('themes', function($app) {
            return new Themes;
        });
    }
}
