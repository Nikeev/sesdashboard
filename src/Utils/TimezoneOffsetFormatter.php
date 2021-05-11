<?php


namespace App\Utils;


class TimezoneOffsetFormatter
{
    /**
     * Formats minutes timezone offset to +-H:i format
     *
     * @param $minutesOffset
     * @return string
     */
    public static function format($minutesOffset): string
    {
        return ($minutesOffset < 0 ? '-' : '+') . date('H:i', mktime(0, abs($minutesOffset)));
    }
}
