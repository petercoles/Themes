<?php

namespace Themes;

use Mockery as m;

class AssetTest extends AbstractBaseTest
{
    public static $url;
    public static $themes;
    public static $globals;

    public function setUp()
    {
        parent::setUp();

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
}
