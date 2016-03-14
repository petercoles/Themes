<?php

namespace Themes\Matchers;

use RunTimeException;

class Dates
{
    public function handle($request, $match)
    {
        $now = date('Y-m-d');

        if (is_string($match)) {
            if ($now == $match) {
                return true;
            }

            return false;
        }

        if (!is_null($match[0]) && !is_null($match[1]) && $match[0] > $match[1]) {
            throw new RunTimeException('End date cannot be before start date');
        }

        if (!is_null($match[0]) && $now < $match[0]) {
            return false;
        }

        if (!is_null($match[1]) && $now > $match[1]) {
            return false; 
        }

        return true;

    }
}
