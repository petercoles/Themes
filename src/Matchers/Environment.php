<?php

namespace Themes\Matchers;

class Environment extends MatcherInterface
{
    public function handle($request, $match)
    {
        return app()->environment() == $match;
    }
}
