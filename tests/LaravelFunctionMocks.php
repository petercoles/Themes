<?php

use Mockery as m;

/*
 * For unit testing we return mocks of the relevant classes
 * that would be bound to the Laravel application container
 * Note: this file must not be namespaced as we need these
 * helper mocks to be available globally
 */
function app($class = null)
{
    if (!$class) {
        return PeterColes\Themes\AbstractBaseTest::$app;
    }

    if ($class == 'url') {
        return PeterColes\Themes\AssetTest::$url;
    }

    if ($class == 'themes') {
        if (isset(debug_backtrace()[1]['class']) && debug_backtrace()[1]['class'] == 'PeterColes\Themes\ThemesMiddleware') {
            return new PeterColes\Themes\Themes;
        }

        return PeterColes\Themes\AssetTest::$themes;
    }

    if ($class == 'config') {
        return PeterColes\Themes\AbstractBaseTest::$config;
    }

    if ($class == 'view.finder') {
        return PeterColes\Themes\AbstractBaseTest::$finder;
    }

    if ($class == 'files') {
        return PeterColes\Themes\AbstractBaseTest::$files;
    }
}

/*
 * We simulate the public_path function 
 */
function public_path($path)
{
    return "/home/test/public/$path";
}
