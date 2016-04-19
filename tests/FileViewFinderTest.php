<?php

namespace PeterColes\Themes;

use Mockery as m;
use PeterColes\Themes\FileViewFinder;

class FileViewFinderTest extends \PHPUnit_Framework_TestCase
{
    public function testAddLocation()
    {
        $fileSystem = m::mock('Illuminate\Filesystem\Filesystem');
        $paths = ['foo'];

        $finder = new FileViewFinder($fileSystem, $paths);
        $finder->addLocation('bar');

        $this->assertEquals(['bar', 'foo'], $finder->getPaths());
    }
}
