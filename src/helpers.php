<?php

use GHJayce\Weapons\Arr;
use GHJayce\Weapons\Dates;

if (!function_exists('array_group')) {
    function array_group(array $array, $key_or_func)
    {
        return Arr::group($array, $key_or_func);
    }
}

if (!function_exists('array_one_dimension')) {
    function array_one_dimension(array $array, $key)
    {
        return Arr::toOneDimension($array, $key);
    }
}

if (!function_exists('to_array')) {
    function to_array($array)
    {
        return Arr::toArray($array);
    }
}

if (!function_exists('date_duration')) {
    function date_duration($previous_time, $latest_time = null)
    {
        return Dates::duration($previous_time, $latest_time);
    }
}

if (!function_exists('is_today')) {
    function is_today($datetime)
    {
        return Dates::isToday($datetime);
    }
}

if (!function_exists('is_yesterday')) {
    function is_yesterday($datetime)
    {
        return Dates::isYesterday($datetime);
    }
}

if (!function_exists('is_tomorrow')) {
    function is_tomorrow($datetime)
    {
        return Dates::isTomorrow($datetime);
    }
}

if (!function_exists('to_date_format')) {
    function to_date_format($timestamp = null)
    {
        return Dates::toDateFormat($timestamp);
    }
}

if (!function_exists('date_common_format')) {
    function date_common_format($timestamp = null)
    {
        return Dates::toCommonFormat($timestamp);
    }
}

if (!function_exists('date_readable')) {
    function date_readable($previous_time)
    {
        return Dates::toReadable($previous_time);
    }
}