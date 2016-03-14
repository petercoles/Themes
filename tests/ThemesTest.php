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
}
