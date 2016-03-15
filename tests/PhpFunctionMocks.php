<?php

namespace Themes;

use Mockery as m;

/*
 * The global PHP function file_exists() will need to return data specific to each test,
 * and so we simulate it with a mock that can be fed test-appropriate responses
 * Note: this file must be namespaced to allow over-riding of the global function
 */
function file_exists($path)
{
    return AssetTest::$globals->file_exists($path);
}
