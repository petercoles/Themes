<?php

namespace Themes\Matchers;

class Domain
{
    public function handle($request, $match)
    {
        return $request->getHost() == $match;
    }
}
