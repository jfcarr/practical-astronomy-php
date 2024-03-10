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

/**
 * Convert a Greenwich Date/Civil Date (day,month,year) to Julian Date
 *
 * Original macro name: CDJD
 */
function civilDateToJulianDate($day, $month, $year)
{
    $fDay = (float) $day;
    $fMonth = (float) $month;
    $fYear = (float) $year;

    $y = ($fMonth < 3) ? $fYear - 1 : $fYear;
    $m = ($fMonth < 3) ? $fMonth + 12 : $fMonth;

    $b = 0; // Initialize $b

    if ($fYear > 1582) {
        $a = floor($y / 100);
        $b = 2 - $a + floor($a / 4);
    } else {
        if ($fYear == 1582 && $fMonth > 10) {
            $a = floor($y / 100);
            $b = 2 - $a + floor($a / 4);
        } else {
            if ($fYear == 1582 && $fMonth == 10 && $day >= 15) {
                $a = floor($y / 100);
                $b = 2 - $a + floor($a / 4);
            }
        }
    }

    $c = ($y < 0) ? floor((365.25 * $y) - 0.75) : floor(365.25 * $y);
    $d = floor(30.6001 * ($m + 1.0));

    return $b + $c + $d + $fDay + 1720994.5;
}


/**
 * Returns the day part of a Julian Date
 *
 * Original macro name: JDCDay
 */
function julianDateDay($julianDate)
{
    $i = floor($julianDate + 0.5);
    $f = $julianDate + 0.5 - $i;
    $a = floor(($i - 1867216.25) / 36524.25);
    $b = ($i > 2299160) ? $i + 1 + $a - floor($a / 4) : $i;
    $c = $b + 1524;
    $d = floor(($c - 122.1) / 365.25);
    $e = floor(365.25 * $d);
    $g = floor(($c - $e) / 30.6001);

    return $c - $e + $f - floor(30.6001 * $g);
}

/**
 * Returns the month part of a Julian Date
 *
 * Original macro name: JDCMonth
 */
function julianDateMonth($julianDate)
{
    $i = floor($julianDate + 0.5);
    $a = floor(($i - 1867216.25) / 36524.25);
    $b = ($i > 2299160) ? $i + 1 + $a - floor($a / 4) : $i;
    $c = $b + 1524;
    $d = floor(($c - 122.1) / 365.25);
    $e = floor(365.25 * $d);
    $g = floor(($c - $e) / 30.6001);

    $returnValue = ($g < 13.5) ? $g - 1 : $g - 13;

    return  $returnValue;
}

/**
 * Returns the year part of a Julian Date
 *
 * Original macro name: JDCYear
 */
function julianDateYear($julianDate)
{
    $i = floor($julianDate + 0.5);
    $a = floor(($i - 1867216.25) / 36524.25);
    $b = ($i > 2299160) ? $i + 1.0 + $a - floor($a / 4.0) : $i;
    $c = $b + 1524;
    $d = floor(($c - 122.1) / 365.25);
    $e = floor(365.25 * $d);
    $g = floor(($c - $e) / 30.6001);
    $h = ($g < 13.5) ? $g - 1 : $g - 13;

    $returnValue = ($h > 2.5) ? $d - 4716 : $d - 4715;

    return  $returnValue;
}
