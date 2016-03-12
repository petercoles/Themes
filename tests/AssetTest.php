<?php

namespace Themes;

use Mockery as m;

/*
 * For unit testing we return mocks of the relevant classes
 * that would be bound to the Laravel application container
 */
function app($class)
{
    if ($class == 'url') {
        return AssetTest::$url;
    }

    if ($class == 'themes') {
        return AssetTest::$themes;
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
 * The global PHP function file_exists() will need to return contextually-relevant data,
 * and so with simulate it with a mock that can be fed test-appropriate responses
 */
function file_exists($path)
{
    return AssetTest::$globals->file_exists($path);
}

class AssetTest extends \PHPUnit_Framework_TestCase
{
    public static $url;
    public static $themes;
    public static $globals;

    public function setUp()
    {
        self::$url = m::mock('\Illuminate\Routing\UrlGenerator');
        self::$themes = m::mock('\Themes\Themes');
        self::$globals = m::mock();
    }

    protected function buildContainer($context, $theme, $secure = null)
    {
        self::$themes->shouldReceive('getContext')->andReturn($context);
        self::$themes->shouldReceive('getTheme')->andReturn($theme);

        $scheme = $secure ? 'https' : 'http';

        if ($theme) {
            self::$url->shouldReceive('asset')->with("$context/$theme/css/main.css", null)->andReturn("$scheme://test.dev/$context/$theme/css/main.css");
        } else {
            self::$url->shouldReceive('asset')->with("css/main.css", null)->andReturn("$scheme://test.dev/css/main.css");
        }
    }

    public function testSiteAsset()
    {
        $this->buildContainer('site', 'foo');
        self::$globals->shouldReceive('file_exists')->with('/home/test/public/site/foo/css/main.css')->andReturn(true);

        $asset = theme_asset('css/main.css');

        $this->assertEquals('http://test.dev/site/foo/css/main.css', $asset);
    }

    public function testSiteDefaultAsset()
    {
        $this->buildContainer('site', 'default');
        self::$globals->shouldReceive('file_exists')->with('/home/test/public/site/foo/css/main.css')->andReturn(false);
        self::$globals->shouldReceive('file_exists')->with('/home/test/public/site/default/css/main.css')->andReturn(true);

        $asset = theme_asset('css/main.css');

        $this->assertEquals('http://test.dev/site/default/css/main.css', $asset);
    }

    public function testSiteCommonAsset()
    {
        $this->buildContainer('site', null);
        self::$globals->shouldReceive('file_exists')->with('/home/test/public/site/default/css/main.css')->andReturn(false);

        $asset = theme_asset('css/main.css');

        $this->assertEquals('http://test.dev/css/main.css', $asset);
    }

    public function testSecureSiteAsset()
    {
        $this->buildContainer('site', 'foo', true);
        self::$globals->shouldReceive('file_exists')->with('/home/test/public/site/foo/css/main.css')->andReturn(true);

        $asset = theme_asset('css/main.css');

        $this->assertEquals('https://test.dev/site/foo/css/main.css', $asset);
    }

    public function testAdminAsset()
    {
        $this->buildContainer('admin', 'foo');
        self::$globals->shouldReceive('file_exists')->with('/home/test/public/admin/foo/css/main.css')->andReturn(true);

        $asset = theme_asset('css/main.css');

        $this->assertEquals('http://test.dev/admin/foo/css/main.css', $asset);
    }


    public function tearDown()
    {
        m::close();
    }
}
