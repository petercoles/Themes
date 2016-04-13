<?php

namespace PeterColes\Themes;

use Mockery as m;

abstract class AbstractBaseTest extends \PHPUnit_Framework_TestCase
{
    public static $app;
    public static $config;
    public static $files;
    public static $finder;

    public function setUp()
    {
        self::$app = m::mock('\Illuminate\Foundation\Application');
        self::$app->shouldReceive('basePath')->withNoArgs()->andReturn('/home/test');
        self::$app->shouldReceive('basePath')->with('foo/bar')->andReturn('/home/test/themes/foo/bar');

        self::$config = m::mock('\\Illuminate\\Config\\Repository');
        self::$files = m::mock('\\Illuminate\\Filesystem\\Filesystem');
        self::$finder = m::mock('\\PeterColes\\Themes\\FileViewFinder');
    }

    public function tearDown()
    {
        m::close();
    }
}
