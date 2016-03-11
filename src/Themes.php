<?php

namespace Themes;

class Themes
{
    /**
     * Add paths for current and default themes to the list that Laravel searches.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    public function addThemePaths($request)
    {
        // set the request context: admin or site
        $context = $this->adminContext($request) ? 'admin' : 'site';

        // get the name of the theme for this context
        $theme = app('config')->get("themes.$context.theme");

        // add default and theme paths to Laravel's view finder path list
        app('view.finder')->addLocation(base_path("resources/$context/default/views"));
        app('view.finder')->addLocation(base_path("resources/$context/$theme/views"));
    }

    /**
     * Determine the context, public site, or admin area, of an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    protected function adminContext($request)
    {
        $adminId = app('config')->get('themes.admin.id');

        return (!is_null($adminId) && (strpos($request->getHost(), $adminId) === 0 || $request->segment(1) == $adminId));
    }
}
