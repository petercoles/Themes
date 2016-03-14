<?php

namespace Themes;

use Mockery as m;

class MatchEnvironmentTest extends AbstractBaseTest
{
    public function setUp()
    {
        parent::setUp();

        $this->request = m::mock('\\Illuminate\\Http\\Request');

        $this->themes = new Themes;
    }

    public function testEnvironmentNotMatched()
    {
        $config = [['match' => 'environment:local', 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$app->shouldReceive('environment')->andReturn('production');
        self::$finder->shouldReceive('addLocation')->never();
        $this->themes->setTheme($this->request);

        $this->assertEquals(null, $this->themes->getTheme());
    }

    public function testDomainMatched()
    {
        $config = [['match' => 'environment:local', 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$finder->shouldReceive('addLocation')->once();
        self::$app->shouldReceive('environment')->andReturn('local');
        $this->themes->setTheme($this->request);

        $this->assertEquals('foo', $this->themes->getTheme());
    }

    public function tearDown()
    {
        m::close();
    }
}
