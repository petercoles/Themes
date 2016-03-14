<?php

namespace Themes;

use Mockery as m;

class ThemesTest extends AbstractBaseTest
{
    public function setUp()
    {
        parent::setUp();

        $this->request = m::mock('\\Illuminate\\Http\\Request');

        $this->themes = new Themes;
    }

    public function testNoThemeSetting()
    {
        self::$config->shouldreceive('get')->with('themes')->andReturn([['theme' => null]]);
        self::$finder->shouldReceive('addLocation')->never();
        $this->themes->setTheme($this->request);

        $this->assertEquals(null, $this->themes->getTheme());
    }

    public function testNullThemeSetting()
    {
        self::$config->shouldreceive('get')->with('themes')->andReturn([['theme' => null]]);
        self::$finder->shouldReceive('addLocation')->never();
        $this->themes->setTheme($this->request);

        $this->assertEquals(null, $this->themes->getTheme());
    }

    public function testBasicThemeSetting()
    {
        self::$config->shouldreceive('get')->with('themes')->andReturn([['theme' => 'foo']]);
        self::$finder->shouldReceive('addLocation')->once();
        $this->themes->setTheme($this->request);

        $this->assertEquals('foo', $this->themes->getTheme());
    }
}
