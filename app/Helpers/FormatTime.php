<?php

if (!function_exists('format_time_diff')) {
    /**
     * Calculate the difference between two dates and return a human-readable string
     *
     * @param string|DateTime $date
     * @return string
     */
    function format_time_diff($date)
    {
        if (!$date) {
            return '';
        }

        // Create a Carbon instance from the date
        $carbonDate = \Carbon\Carbon::parse($date);
        $now = \Carbon\Carbon::now();

        // If the date is in the future, just return "in X time"
        if ($carbonDate > $now) {
            return $carbonDate->diffForHumans($now, ['parts' => 2]);
        }

        // Otherwise, return the time difference
        return $carbonDate->diffForHumans($now, ['parts' => 2]);
    }
}