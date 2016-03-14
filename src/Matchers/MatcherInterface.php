<?php

namespace Themes\Matchers;

interface MatcherInterface extends MatcherInterface
{
    public function handle($request, $match);
}
