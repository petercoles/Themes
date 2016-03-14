<?php

namespace Themes;

if (!function_exists('themes_path')) {
    /**
     * Get the path to the themes folder.
     *
     * @param  string  $path
     * @return string
     */
    function themes_path($path = '')
    {
        return app()->basePath().DIRECTORY_SEPARATOR.'themes'.($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}

if (!function_exists('theme_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @return string
     */
    function theme_asset($path, $secure = null)
    {
        $theme = app('themes')->getTheme();

        if ($theme && file_exists(public_path("$theme/$path"))) {
            return app('url')->asset("$theme/$path", $secure);
        }

        return app('url')->asset($path, $secure);
    }
}

if (!function_exists('secure_theme_asset')) {
    /**
     * Generate a secure asset path for the theme asset.
     *
     * @param  string  $path
     * @return string
     */
    function secure_theme_asset($path)
    {
        return theme_asset($path, true);
    }
}
