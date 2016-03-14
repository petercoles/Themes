<?php

namespace Themes;

use Carbon\Carbon;
use Mockery as m;

class MatchDatesTest extends AbstractBaseTest
{
    public function setUp()
    {
        parent::setUp();

        $this->request = m::mock('\\Illuminate\\Http\\Request');

        $this->themes = new Themes;

        $this->lastWeek = Carbon::today()->subWeek()->format('Y-m-d');
        $this->yesterday = Carbon::yesterday()->format('Y-m-d');
        $this->today = Carbon::today()->format('Y-m-d');
        $this->tomorrow = Carbon::tomorrow()->format('Y-m-d');
        $this->nextWeek = Carbon::today()->addWeek()->format('Y-m-d');
    }

    /**
     * @expectedException RunTimeException
     */
    public function testNoDates()
    {
        $config = [['match' => "dates", 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$finder->shouldReceive('addLocation')->never();
        $this->themes->setTheme($this->request);
    }

    public function testSingleDateNoMatch()
    {
        $config = [['match' => "dates:$this->yesterday", 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$finder->shouldReceive('addLocation')->never();
        $this->themes->setTheme($this->request);

        $this->assertEquals(null, $this->themes->getTheme());
    }

    public function testSingleDateMatches()
    {
        $config = [['match' => "dates:$this->today", 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$finder->shouldReceive('addLocation')->once();
        $this->themes->setTheme($this->request);

        $this->assertEquals('foo', $this->themes->getTheme());
    }

    /**
     * @expectedException RunTimeException
     */
    public function testDateRangeWithOrderProblem()
    {
        $config = [['match' => "dates:$this->tomorrow,$this->yesterday", 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$finder->shouldReceive('addLocation')->never();
        $this->themes->setTheme($this->request);
    }

    public function testDateRangeExpired()
    {
        $config = [['match' => "dates:$this->lastWeek,$this->yesterday", 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$finder->shouldReceive('addLocation')->never();
        $this->themes->setTheme($this->request);

        $this->assertEquals(null, $this->themes->getTheme());
    }

    public function testDateRangeInRange()
    {
        $config = [['match' => "dates:$this->yesterday,$this->tomorrow", 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$finder->shouldReceive('addLocation')->once();
        $this->themes->setTheme($this->request);

        $this->assertEquals('foo', $this->themes->getTheme());
    }

    public function testDateRangeInFuture()
    {
        $config = [['match' => "dates:$this->tomorrow,$this->nextWeek", 'theme' => 'foo']];
        self::$config->shouldReceive('get')->with('themes')->andReturn($config);
        self::$finder->shouldReceive('addLocation')->never();
        $this->themes->setTheme($this->request);

        $this->assertEquals(null, $this->themes->getTheme());
    }
}
