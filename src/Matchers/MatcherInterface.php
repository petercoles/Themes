<?php

namespace PeterColes\Themes\Matchers;

interface MatcherInterface
{
    public function handle($request, $match);
}
