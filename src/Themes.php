<?php

namespace Themes;

class Themes
{
    protected $context;

    protected $theme;

    /**
     * Set the request context: admin or site (at present).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    public function setContext($request)
    {
        $this->context = $this->adminContext($request) ? 'admin' : 'site';
    }

    public function getContext()
    {
        return $this->context;
    }

    /**
     * get the name of the theme for this context.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    public function setTheme($request)
    {
        $this->theme = app('config')->get("themes.$this->context.theme");
    }

    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Add paths for current and default themes to the list that Laravel searches.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    public function addThemePaths($request)
    {
        app('view.finder')->addLocation(base_path("resources/$this->context/default/views"));
        app('view.finder')->addLocation(base_path("resources/$this->context/$this->theme/views"));
    }

    /**
     * Determine the context: public site, or admin area, of an incoming request.
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
