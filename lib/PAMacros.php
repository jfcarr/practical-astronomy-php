<?php

/**
 * Convert a Civil Time (hours,minutes,seconds) to Decimal Hours
 * 
 * Original macro name: HMSDH
 */
function convertCivilTimeToDecimalHours($hours,  $minutes,  $seconds)
{
    (float) $fHours = $hours;
    (float) $fMinutes = $minutes;
    (float) $fSeconds = $seconds;

    $a = abs($fSeconds) / 60;
    $b = (abs($fMinutes) + $a) / 60;
    $c = abs($fHours) + $b;

    return ($fHours < 0 || $fMinutes < 0 || $fSeconds < 0) ? -$c : $c;
}

/**
 * Return the hour part of a Decimal Hours
 * 
 * Original macro name: DHHour
 */
function decimalHoursHour($decimalHours)
{
    $a = abs($decimalHours);
    $b = $a * 3600;
    $c = round(floor($b - 60 * ($b / 60)), 2);
    $e = ($c == 60) ? $b + 60 : $b;

    return ($decimalHours < 0) ? (int)- (floor(($e / 3600))) : (int)floor($e / 3600);
}

/**
 * Return the minutes part of a Decimal Hours
 *
 * Original macro name: DHMin
 */
function decimalHoursMinute($decimalHours)
{
    $a = abs($decimalHours);
    $b = $a * 3600;
    $c = round($b - 60 * floor($b / 60), 2);
    $e = ($c == 60) ? $b + 60 : $b;

    return (int)floor($e / 60) % 60;
}

/**
 * Return the seconds part of a Decimal Hours
 *
 * Original macro name: DHSec
 */
function decimalHoursSecond($decimalHours)
{
    $a = abs($decimalHours);
    $b = $a * 3600;
    $c = round($b - 60 * floor($b / 60), 2);
    $d = ($c == 60) ? 0 : $c;

    return $d;
}
