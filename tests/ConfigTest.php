<?php

namespace PeterColes\Themes;

use Mockery as m;

class ConfigTest extends AbstractBaseTest
{
    public function setUp()
    {
        parent::setUp();

        self::$config->shouldreceive('get')->with('themes')->andReturn([['theme' => 'foo']]);
        self::$finder->shouldReceive('addLocation')->once();

        $this->request = m::mock('\\Illuminate\\Http\\Request');

        $this->themes = new Themes;
    }

    public function testNoConfig()
    {
        self::$files->shouldReceive('exists')->andReturn(false);
        self::$files->shouldReceive('set')->never();

        $this->themes->setTheme($this->request);
        $this->addToAssertionCount(1);
    }

    public function testHasConfig()
    {
        $file = m::mock('splFileInfo');
        $file->shouldReceive('getExtension')->andReturn('php');
        $file->shouldReceive('getFilename')->andReturn('test.php');
        $file->shouldReceive('getPathname')->andReturn('config/test.php');

        self::$files->shouldReceive('exists')->andReturn(true);
        self::$files->shouldReceive('allFiles')->andReturn([$file]);
        self::$config->shouldReceive('set')->withArgs(['test', ['foo' => 'bar']])->once();

        $this->themes->setTheme($this->request);
        $this->addToAssertionCount(1);
    }
}
