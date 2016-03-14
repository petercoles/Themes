<?php

namespace Themes\Matchers;

class Environment
{
    public function handle($request, $match)
    {
        return app()->environment() == $match;
    }
}
