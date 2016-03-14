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
        $this->findMatch($request);
        $this->addThemePath();
    }

    /**
     * Getter for the theme that is chosen.
     *
     * @return string theme
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * Iterate over the match criteria until a successful match is achieved.
     *
     * @return void
     */
    protected function findMatch($request)
    {
        foreach (app('config')->get('themes') as $match)
        {
            if ($this->testMatch($request, $match)) {
                break;
            }
        }
    }

    /**
     * If there's no match critera or all rules are matched, set the theme and exit.
     *
     * @return void|boolean
     */
    protected function testMatch($request, $match)
    {
        if (!isset($match['match'])) {
            $this->theme = $match['theme'];
            return true;
        }

        $rules = $this->explodeRules($match['match']);

        foreach ($rules as $rule) {
            if ($this->handleRule($request, $rule)) {
                $this->theme = $match['theme'];
                return true;
            }
        }
    }

    /**
     * Remove whtespace from rules and separate the rules in a match group.
     *
     * @return array rules
     */
    protected function explodeRules($rules)
    {
        $rules = preg_replace('/\s+/', '', $rules);
        return explode('|', $rules);
    }

    /**
     * Separate rule name from parameters and pass to matcher class to evaluate.
     *
     * @return boolean
     */
    protected function handleRule($request, $rule)
    {
        $rule = explode(':', $rule);
        $params = isset($rule[1]) ? $rule[1] : null;
        $class = '\\Themes\\Matchers\\'.studly_case($rule[0]);

        return (new $class)->handle($request, $params);
    }

    /**
     * Add path for current theme's views to the list that Laravel searches.
     *
     * @return void
     */
    protected function addThemePath()
    {
        if ($this->theme) {
            app('view.finder')->addLocation(themes_path($this->theme.'/views'));
        }
    }
}
