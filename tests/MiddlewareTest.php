<?php

namespace PeterColes\Themes;

use Mockery as m;
use PeterColes\Themes\Themes;
use PeterColes\Themes\ThemesMiddleware;

class MiddlewareTest extends AbstractBaseTest
{
    public static $themes;

    public function setUp()
    {
        parent::setUp();

        $this->request = m::mock('\\Illuminate\\Http\\Request');
        self::$config->shouldReceive('get')->with('themes')->andReturn(['theme' => null]);
        self::$files->shouldReceive('exists')->andReturn(false);

        $this->next = function() { return 'closure'; };

        self::$themes = new Themes;
    }

    public function tearDown()
    {
        m::close();
    }

    public function testhandle()
    {
        $middleware = new ThemesMiddleware();
        
        $this->assertEquals('closure', $middleware->handle($this->request, $this->next));
    }
}
