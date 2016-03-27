<?php

namespace PeterColes\Themes\Matchers;

class Subdomain implements MatcherInterface
{
    public function handle($request, $match)
    {
        return strpos($request->getHost(), $match) === 0;
    }
}
