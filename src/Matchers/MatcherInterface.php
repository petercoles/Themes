<?php

namespace Themes\Matchers;

interface MatcherInterface
{
    public function handle($request, $match);
}
