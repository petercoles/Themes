<?php

namespace PeterColes\Themes;

use Mockery as m;

class MatchUrlSegmentTest extends AbstractBaseTest
{
    public function setUp()
    {
        parent::setUp();

        $this->request = m::mock('\\Illuminate\\Http\\Request');

        $this->themes = new Themes;
    }

    public function testUrlSegmentNotMatched()
    {
        $config = [['match' => 'url_segment:admin', 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$finder->shouldReceive('addLocation')->never();
        $this->request->shouldReceive('segment')->with(1)->andReturn('bar');
        $this->themes->setTheme($this->request);

        $this->assertEquals(null, $this->themes->getTheme());
    }

    public function testUrlSegmentMatched()
    {
        $config = [['match' => 'url_segment:admin', 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$finder->shouldReceive('addLocation')->once();
        $this->request->shouldReceive('segment')->with(1)->andReturn('admin');
        $this->themes->setTheme($this->request);

        $this->assertEquals('foo', $this->themes->getTheme());
    }

    public function tearDown()
    {
        m::close();
    }
}
