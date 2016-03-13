<?php

namespace Themes;

use Mockery as m;

class ThemesTest extends \PHPUnit_Framework_TestCase
{
    public static $config;
    public static $finder;

    public function setUp()
    {
        self::$config = m::mock('\\Illuminate\\Config\\Repository');
        self::$finder = m::mock('\\Themes\\FileViewFinder');

        $this->request = m::mock('\\Illuminate\\Http\\Request');

        $this->themes = new Themes;
    }

    public function testNoThemeSetting()
    {
        app('config')->shouldreceive('get')->with('themes')->andReturn([['theme' => null]]);
        app('view.finder')->shouldReceive('addLocation')->never();

        $this->themes->setTheme($this->request);

        $this->assertEquals(null, $this->themes->getTheme());
    }

    public function testNullThemeSetting()
    {
        app('config')->shouldreceive('get')->with('themes')->andReturn([['theme' => null]]);
        app('view.finder')->shouldReceive('addLocation')->never();

        $this->themes->setTheme($this->request);

        $this->assertEquals(null, $this->themes->getTheme());
    }

    public function testBasicThemeSetting()
    {
        app('config')->shouldreceive('get')->with('themes')->andReturn([['theme' => 'foo']]);
        app('view.finder')->shouldReceive('addLocation')->once();

        $this->themes->setTheme($this->request);

        $this->assertEquals('foo', $this->themes->getTheme());
    }

    public function tearDown()
    {
        m::close();
    }
}
