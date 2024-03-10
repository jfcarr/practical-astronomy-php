<?php

include 'PAMacros.php';
include 'PAUtils.php';

/**
 * Calculates the date of Easter for the year specified.
 */
function getDateOfEaster($inputYear)
{
    $year = $inputYear;

    $a = $year % 19;

    $b = floor(($year / 100));
    $c = $year % 100;
    $d = floor(($b / 4));
    $e = $b % 4;
    $f = floor((($b + 8) / 25));
    $g = floor((($b - $f + 1) / 3));
    $h = ((19 * $a) + $b - $d - $g + 15) % 30;
    $i = floor(($c / 4));
    $k = $c % 4;
    $l = (32 + 2 * ($e + $i) - $h - $k) % 7;
    $m = floor((($a + (11 * $h) + (22 * $l)) / 451));
    $n = floor((($h + $l - (7 * $m) + 114) / 31));
    $p = ($h + $l - (7 * $m) + 114) % 31;

    $day = $p + 1;
    $month = $n;

    return array((int) $month, (int) $day, (int) $year);
}

/**
 * Calculate day number for a date.
 */
function civilDateToDayNumber($month, $day, $year)
{
    if ($month <= 2) {
        $month = $month - 1;
        $month = (isLeapYear($year)) ? $month * 62 : $month * 63;
        $month = floor((int)((float)$month / 2));
    } else {
        $month = floor((int)(((float)$month + 1) * 30.6));
        $month = (isLeapYear($year)) ? $month - 62 : $month - 63;
    }

    return $month + $day;
}


/**
 * Convert a Civil Time (hours,minutes,seconds) to Decimal Hours
 */
function civilTimeToDecimalHours($hours, $minutes, $seconds)
{
    return convertCivilTimeToDecimalHours($hours, $minutes, $seconds);
}

/**
 * Convert Decimal Hours to Civil Time
 */
function decimalHoursToCivilTime($decimalHours)
{
    $hours = decimalHoursHour($decimalHours);
    $minutes = decimalHoursMinute($decimalHours);
    $seconds = decimalHoursSecond($decimalHours);

    return array($hours, $minutes, $seconds);
}

/**
 * Convert local Civil Time to Universal Time
 */
function localCivilTimeToUniversalTime($lctHours, $lctMinutes, $lctSeconds, $isDaylightSavings, $zoneCorrection, $localDay, $localMonth, $localYear)
{
    $lct = civilTimeToDecimalHours($lctHours, $lctMinutes, $lctSeconds);

    $daylightSavingsOffset = ($isDaylightSavings) ? 1 : 0;

    $utInterim = $lct - $daylightSavingsOffset - $zoneCorrection;
    $gdayInterim = $localDay + ($utInterim / 24);

    $jd = civilDateToJulianDate($gdayInterim, $localMonth, $localYear);

    $gDay = julianDateDay($jd);
    $gMonth = julianDateMonth($jd);
    $gYear = julianDateYear($jd);

    $ut = 24 * ($gDay - floor($gDay));

    $returnValue = array(
        decimalHoursHour($ut),
        decimalHoursMinute($ut),
        (int)decimalHoursSecond($ut),
        (int)floor($gDay),
        $gMonth,
        $gYear
    );

    return $returnValue;
}

/**
 * Convert Universal Time to local Civil Time
 */
function universalTimeToLocalCivilTime($utHours, $utMinutes, $utSeconds, $isDaylightSavings, $zoneCorrection, $gwDay, $gwMonth, $gwYear)
{
    $dstValue = ($isDaylightSavings) ? 1 : 0;
    $ut = convertCivilTimeToDecimalHours($utHours, $utMinutes, $utSeconds);
    $zoneTime = $ut + $zoneCorrection;
    $localTime = $zoneTime + $dstValue;
    $localJDPlusLocalTime = civilDateToJulianDate($gwDay, $gwMonth, $gwYear) + ($localTime / 24);
    $localDay = julianDateDay($localJDPlusLocalTime);
    $integerDay = floor($localDay);
    $localMonth = julianDateMonth($localJDPlusLocalTime);
    $localYear = julianDateYear($localJDPlusLocalTime);

    $lct = 24 * ($localDay - $integerDay);

    return array(
        decimalHoursHour($lct),
        decimalHoursMinute($lct),
        (int) decimalHoursSecond($lct),
        (int) $integerDay,
        $localMonth,
        $localYear
    );
}
