<?php

namespace Themes\Matchers;

class UrlSegment
{
    public function handle($request, $match)
    {
        return $request->segment(1) == $match;
    }
}
