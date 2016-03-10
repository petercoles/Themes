<?php

namespace Themes;

use Closure;

class Middleware
{
    public function handle($request, Closure $next)
    {
        // do theme stuff here

        return $next($request);
    }
}
