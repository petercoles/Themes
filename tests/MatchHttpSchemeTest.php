<?php

namespace Themes;

use Mockery as m;

class MatchHttpSchemeTest extends AbstractBaseTest
{
    public function setUp()
    {
        parent::setUp();

        $this->request = m::mock('\\Illuminate\\Http\\Request');

        $this->themes = new Themes;
    }

    public function testSchemeNotMatched()
    {
        $config = [['match' => 'http_scheme:bar', 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$finder->shouldReceive('addLocation')->never();
        $this->request->shouldReceive('getScheme')->andReturn('http');
        $this->themes->setTheme($this->request);

        $this->assertEquals(null, $this->themes->getTheme());
    }

    public function testSchemeMatchesHttp()
    {
        $config = [['match' => 'http_scheme:http', 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$finder->shouldReceive('addLocation')->once();
        $this->request->shouldReceive('getScheme')->andReturn('http');
        $this->themes->setTheme($this->request);

        $this->assertEquals('foo', $this->themes->getTheme());
    }

    public function testSchemeMatchesHttps()
    {
        $config = [['match' => 'http_scheme:https', 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$finder->shouldReceive('addLocation')->once();
        $this->request->shouldReceive('getScheme')->andReturn('https');
        $this->themes->setTheme($this->request);

        $this->assertEquals('foo', $this->themes->getTheme());
    }

    public function tearDown()
    {
        m::close();
    }
}
