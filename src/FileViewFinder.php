<?php

namespace Themes;

use Illuminate\View\FileViewFinder as IlluminateFileViewFinder;

class FileViewFinder extends IlluminateFileViewFinder
{
    /**
     * Add a location to the finder.
     * Differs from standard Laravel as that adds locations to the end of
     * the array, but we want the added themes to be considered first
     *
     * @param  string  $location
     * @return void
     */
    public function addLocation($location)
    {
        array_unshift($this->paths, $location);
    }
}
