<?php

namespace Themes\Matchers;

use RunTimeException;

class Dates implements MatcherInterface
{
    public function handle($request, $match)
    {
        $now = date('Y-m-d');

        $date = explode(',', $match);

        if (count($date) == 1) {
            if ($now == $date[0]) {
                return true;
            }

            return false;
        }

        if ($date[0] != 'null' && $date[1] != 'null' && $date[0] > $date[1]) {
            throw new RunTimeException('End date cannot be before start date');
        }

        if ($date[0] != 'null' && $now < $date[0]) {
            return false;
        }

        if ($date[1] != 'null' && $date[1] < $now) {
            return false; 
        }

        return true;
    }
}
