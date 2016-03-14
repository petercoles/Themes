<?php

namespace Themes\Matchers;

use RunTimeException;

class Dates implements MatcherInterface
{
    public function handle($request, $match)
    {
        if (!$match) {
            throw new RunTimeException('Missing dates for matching');
        }

        $now = date('Y-m-d');

        $date = explode(',', $match);

        if (count($date) == 1) {

            if ($date[0] < $now) {
                return false;
            }
            return true;
        }

        if ($date[0] > $date[1]) {
            throw new RunTimeException('End date cannot be before start date');
        }

        if ($now < $date[0]) {
            return false;
        }

        if ($date[1] < $now) {
            return false; 
        }

        return true;
    }
}
