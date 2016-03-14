<?php

namespace Themes;

use Mockery as m;

class MatchSubDomainTest extends AbstractBaseTest
{
    public function setUp()
    {
        parent::setUp();

        $this->request = m::mock('\\Illuminate\\Http\\Request');

        $this->themes = new Themes;
    }

    public function testSubDomainNotMatched()
    {
        $config = [['match' => ['sub_domain' => 'admin'], 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$finder->shouldReceive('addLocation')->never();
        $this->request->shouldReceive('getHost')->andReturn('www.test.tld');
        $this->themes->setTheme($this->request);

        $this->assertEquals(null, $this->themes->getTheme());
    }

    public function testSubDomainMatched()
    {
        $config = [['match' => ['sub_domain' => 'admin'], 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$finder->shouldReceive('addLocation')->once();
        $this->request->shouldReceive('getHost')->andReturn('admin.test.tld');
        $this->themes->setTheme($this->request);

        $this->assertEquals('foo', $this->themes->getTheme());
    }

    public function tearDown()
    {
        m::close();
    }
}
