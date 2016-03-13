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

    protected function buildContainer($theme, $secure = null)
    {
        self::$themes->shouldReceive('getTheme')->andReturn($theme);

        $scheme = $secure ? 'https' : 'http';

        if ($theme) {
            self::$url->shouldReceive('asset')->with("$theme/css/main.css", null)->andReturn("$scheme://test.dev/$theme/css/main.css");
        }

        self::$url->shouldReceive('asset')->with("css/main.css", null)->andReturn("$scheme://test.dev/css/main.css");
    }

    public function testThemesPathNoParam()
    {
        $path = themes_path();

        $this->assertEquals('/home/test/themes', $path);
    }

    public function testThemesPathWithParam()
    {
        $path = themes_path('foo/bar');

        $this->assertEquals('/home/test/themes/foo/bar', $path);
    }

    public function testAssetBelongingToThemeFound()
    {
        $this->buildContainer('foo');
        self::$globals->shouldReceive('file_exists')->with('/home/test/public/foo/css/main.css')->andReturn(true);

        $asset = theme_asset('css/main.css');

        $this->assertEquals('http://test.dev/foo/css/main.css', $asset);
    }

    public function testFallbackToCommonAsset()
    {
        $this->buildContainer('foo');
        self::$globals->shouldReceive('file_exists')->with('/home/test/public/foo/css/main.css')->andReturn(false);

        $asset = theme_asset('css/main.css');

        $this->assertEquals('http://test.dev/css/main.css', $asset);
    }

    public function testSiteCommonAsset()
    {
        $this->buildContainer(null);

        $asset = theme_asset('css/main.css');

        $this->assertEquals('http://test.dev/css/main.css', $asset);
    }

    public function testSecureSiteAsset()
    {
        $this->buildContainer('foo', true);
        self::$globals->shouldReceive('file_exists')->with('/home/test/public/foo/css/main.css')->andReturn(true);

        $asset = theme_asset('css/main.css');

        $this->assertEquals('https://test.dev/foo/css/main.css', $asset);
    }

    public function tearDown()
    {
        m::close();
    }
}
