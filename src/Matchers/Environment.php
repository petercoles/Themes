<?php

namespace PeterColes\Themes\Matchers;

class Environment implements MatcherInterface
{
    public function handle($request, $match)
    {
        return app()->environment() == $match;
    }
}
