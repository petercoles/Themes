<?php

use Mockery as m;

/*
 * For unit testing we return mocks of the relevant classes
 * that would be bound to the Laravel application container
 */
function app($class = null)
{
    if (!$class) {
        return Themes\AbstractBaseTest::$app;
    }

    if ($class == 'url') {
        return Themes\AssetTest::$url;
    }

    if ($class == 'themes') {
        return Themes\AssetTest::$themes;
    }

    if ($class == 'config') {
        return Themes\AbstractBaseTest::$config;
    }

    if ($class == 'view.finder') {
        return Themes\AbstractBaseTest::$finder;
    }
}

/*
 * We simulate the public_path function 
 */
function public_path($path)
{
    return "/home/test/public/$path";
}