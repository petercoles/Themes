<?php

namespace Themes\Matchers;

class UrlSegment extends MatcherInterface
{
    public function handle($request, $match)
    {
        return $request->segment(1) == $match;
    }
}
