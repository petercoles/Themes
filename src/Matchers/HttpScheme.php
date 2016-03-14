<?php

namespace Themes\Matchers;

class HttpScheme
{
    public function handle($request, $match)
    {
        return $request->getScheme() == $match;
    }
}
