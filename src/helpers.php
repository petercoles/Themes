<?php

if (! function_exists('theme_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @return string
     */
    function theme_asset($path, $secure = null)
    {
        return app('url')->asset($path, $secure);
    }
}

if (! function_exists('secure_theme_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @return string
     */
    function secure_theme_asset($path)
    {
        return theme_asset($path, true);
    }
}
