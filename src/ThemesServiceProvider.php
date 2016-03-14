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
        $this->registerViewFinder();

        $this->registerThemes();
    }

    /**
     * Re-register the view finder to use use local copy.
     *
     * @return void
     */
    protected function registerViewFinder()
    {
        $this->app['view.finder'] = $this->app->bind(function($app) {
            $paths = $app['config']['view.paths'];

            return new FileViewFinder($app['files'], $paths);
        });
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
}
