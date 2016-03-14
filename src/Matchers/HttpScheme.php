<?php

namespace Themes\Matchers;

class HttpScheme implements MatcherInterface
{
    public function handle($request, $match)
    {
        return $request->getScheme() == $match;
    }
}
