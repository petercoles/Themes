<?php

namespace Themes;

use Mockery as m;

class MatchMultipleTest extends AbstractBaseTest
{
    public function setUp()
    {
        parent::setUp();

        $this->request = m::mock('\\Illuminate\\Http\\Request');

        $this->themes = new Themes;
    }

    public function testDomainAndSchemeNotMatched()
    {
        $config = [['match' => 'domain:www.test.tld|http_scheme:https', 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$finder->shouldReceive('addLocation')->never();
        $this->request->shouldReceive('getHost')->andReturn('www.test.tld');
        $this->request->shouldReceive('getScheme')->andReturn('http');
        $this->themes->setTheme($this->request);

        $this->assertEquals(null, $this->themes->getTheme());
    }

    public function testDomainMatched()
    {
        $config = [['match' => 'domain:www.test.tld|http_scheme:https', 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$finder->shouldReceive('addLocation')->once();
        $this->request->shouldReceive('getHost')->andReturn('www.test.tld');
        $this->request->shouldReceive('getScheme')->andReturn('https');
        $this->themes->setTheme($this->request);

        $this->assertEquals('foo', $this->themes->getTheme());
    }

    public function tearDown()
    {
        m::close();
    }
}
