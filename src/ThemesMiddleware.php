<?php

namespace Themes;

use Closure;

class ThemesMiddleware
{
    /**
     * The themes service class instance.
     *
     * @var \Themes\Themes
     */
    protected $themes;

    /**
     * Create a new CookieQueue instance.
     *
     * @param  \Themes\Themes  $themes
     * @return void
     */
    public function __construct(Themes $themes)
    {
        $this->themes = $themes;
    }

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
        $this->themes->addThemePaths($request);

        return $next($request);
    }
}
