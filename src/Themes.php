<?php

namespace Themes;

class Themes
{
    protected $theme = null;

    /**
     * get the name of the theme for this context.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    public function setTheme($request)
    {
        $this->matchRules($request);
        $this->addThemePath();
    }

    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Add path for current theme's views to the list that Laravel searches.
     *
     * @return void
     */
    protected function addThemePath()
    {
        if ($this->theme) {
           app('view.finder')->addLocation(themes_path($this->theme . '/views'));
        }
    }

    /**
     * Determine the context: public site, or admin area, of an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function matchRules($request)
    {
        foreach (app('config')->get('themes') as $rule)
        {
            if ($this->testForMatch($request, $rule)) {
                break;
            }
        }
    }

    /**
     * Determine the context: public site, or admin area, of an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return boolean
     */
    protected function testForMatch($request, $rule)
    {
        // Check validity of rules provided
        if (!isset($rule['match'])) {
            if (!isset($rule['theme'])) {
                $rule['theme'] = null;
            }

            // If there's a theme, but nothing to match against, set the theme
            // This is the default state of the config file
            $this->theme = $rule['theme'];
            return true;
        }

        // Iterate over the rules to be matched. If any fail, return false
        foreach ($rule['match'] as $type => $match) {
            $class = '\\Themes\\Matchers\\' . studly_case($type);

            if (! (new $class)->handle($request, $match)) {
                return false;
            }
        }

        // Since all rules matched, set the theme and return true
        $this->theme = $rule['theme'];
        return true;
    }
}
