<?php

namespace Themes;

use Mockery as m;

/*
 * For unit testing we return mocks of the relevant classes
 * that would be bound to the Laravel application container
 */
function app($class = null)
{
    if (!$class) {
        $app = m::mock('\Illuminate\Foundation\Application');
        $app->shouldReceive('basePath')->withNoArgs()->andReturn('/home/test');
        $app->shouldReceive('basePath')->with('foo/bar')->andReturn('/home/test/themes/foo/bar');
        return $app;
    }

    if ($class == 'url') {
        return AssetTest::$url;
    }

    if ($class == 'themes') {
        return AssetTest::$themes;
    }

    if ($class == 'config') {
        return AbstractBaseTest::$config;
    }

    if ($class == 'view.finder') {
        return AbstractBaseTest::$finder;
    }
}

/*
 * We simulate the public_path function 
 */
function public_path($path)
{
    return "/home/test/public/$path";
}

/*
 * The global PHP function file_exists() will need to return data specific to each test,
 * and so we simulate it with a mock that can be fed test-appropriate responses
 */
function file_exists($path)
{
    return AssetTest::$globals->file_exists($path);
}
