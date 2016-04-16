<?php

namespace PeterColes\Themes;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Http\Kernel;

class ThemesServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot(Kernel $kernel)
    {
        $this->publishes([
            __DIR__.'/../config/themes.php' => config_path('themes.php'),
        ]);

        // Apply themes middleware to all routes
        $kernel->prependMiddleware(ThemesMiddleware::class);
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
}
