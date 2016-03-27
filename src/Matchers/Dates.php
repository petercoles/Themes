<?php

namespace PeterColes\Themes\Matchers;

use RunTimeException;

class Dates implements MatcherInterface
{
    public function handle($request, $match)
    {
        if (!$match) {
            throw new RunTimeException('Missing dates for matching');
        }

        $date = explode(',', $match);

        if (count($date) == 1) {
            return $this->matchSingleDate($date[0]);
        }

        return $this->matchDateRange($date[0], $date[1]);
    }

    protected function matchSingleDate($date)
    {
        $now = date('Y-m-d');

        if ($date < $now) {
            return false;
        }

        return true;
    }

    protected function matchDateRange($begin, $end)
    {
        if ($begin > $end) {
            throw new RunTimeException('End date cannot be before start date');
        }

        $now = date('Y-m-d');

        if ($now < $begin) {
            return false;
        }

        if ($end < $now) {
            return false; 
        }

        return true;
    }
}
