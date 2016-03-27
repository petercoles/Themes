<?php

namespace PeterColes\Themes;

use Mockery as m;

class MatchDomainTest extends AbstractBaseTest
{
    public function setUp()
    {
        parent::setUp();

        $this->request = m::mock('\\Illuminate\\Http\\Request');

        $this->themes = new Themes;
    }

    public function testDomainNotMatched()
    {
        $config = [['match' => 'domain:www.test.tld', 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$finder->shouldReceive('addLocation')->never();
        $this->request->shouldReceive('getHost')->andReturn('www.not-test.tld');
        $this->themes->setTheme($this->request);

        $this->assertEquals(null, $this->themes->getTheme());
    }

    public function testDomainMatched()
    {
        $config = [['match' => 'domain:www.test.tld', 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$finder->shouldReceive('addLocation')->once();
        $this->request->shouldReceive('getHost')->andReturn('www.test.tld');
        $this->themes->setTheme($this->request);

        $this->assertEquals('foo', $this->themes->getTheme());
    }

    public function tearDown()
    {
        m::close();
    }
}
