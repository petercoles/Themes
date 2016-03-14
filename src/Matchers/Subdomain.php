<?php

namespace Themes\Matchers;

class Subdomain extends MatcherInterface
{
    public function handle($request, $match)
    {
        return strpos($request->getHost(), $match) === 0;
    }
}
