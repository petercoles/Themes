<?php

namespace Themes\Matchers;

class Subdomain
{
    public function handle($request, $match)
    {
        return strpos($request->getHost(), $match) === 0;
    }
}
