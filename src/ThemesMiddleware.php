<?php

namespace Themes;

use Closure;

class ThemesMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // set the request context: admin or site
        app('themes')->setContext($request);

        // get the name of the theme for this context
        app('themes')->setTheme($request);

        // add paths to the theme's views
        app('themes')->addThemePaths($request);

        return $next($request);
    }
}
