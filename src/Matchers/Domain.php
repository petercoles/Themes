<?php

namespace Themes\Matchers;

class Domain extends MatcherInterface
{
    public function handle($request, $match)
    {
        return $request->getHost() == $match;
    }
}
