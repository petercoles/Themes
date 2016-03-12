<?php

namespace Themes;

if (! function_exists('theme_asset')) {
    /**
     * Generate an asset path for the application.
     *
     * @param  string  $path
     * @return string
     */
    function theme_asset($path, $secure = null)
    {
        $theme = app('themes')->getTheme();

        $context = app('themes')->getContext();

        if ($theme && file_exists(public_path("$context/$theme/$path"))) {
            return app('url')->asset("$context/$theme/$path", $secure);
        }

        if (file_exists(public_path("$context/default/$path"))) {
            return app('url')->asset("$context/default/$path", $secure);
        }

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
