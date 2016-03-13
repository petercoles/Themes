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
        // determine and apply the theme for this request
        app('themes')->setTheme($request);

        return $next($request);
    }
}
