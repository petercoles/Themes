<?php

namespace Themes;

use Mockery as m;

abstract class AbstractBaseTest extends \PHPUnit_Framework_TestCase
{
    public static $config;
    public static $finder;

    public function tearDown()
    {
        m::close();
    }
}
