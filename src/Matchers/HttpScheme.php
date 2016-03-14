<?php

namespace Themes\Matchers;

class HttpScheme extends MatcherInterface
{
    public function handle($request, $match)
    {
        return $request->getScheme() == $match;
    }
}
