<?php

use Mockery as m;

/*
 * For unit testing we mock the Laravel application container
 */
function app($index)
{
    $app = m::mock('Illuminate\Foundation\Application');
    $app->shouldReceive('asset')->with('foo', null)->andReturn('http://test.dev/foo');
    $app->shouldReceive('asset')->with('foo', true)->andReturn('https://test.dev/foo');

    return $app;
}

class AssetTest extends \PHPUnit_Framework_TestCase
{
    public function testThemeAsset()
    {
        $result = theme_asset('foo');

        $this->assertEquals('http://test.dev/foo', $result);
    }

    public function testThemeAssetForcedSecure()
    {
        $result = theme_asset('foo', true);

        $this->assertEquals('https://test.dev/foo', $result);
    }

    public function testSecureThemeAsset()
    {
        $result = secure_theme_asset('foo');

        $this->assertEquals('https://test.dev/foo', $result);
    }

    public function tearDown()
    {
        m::close();
    }
}
