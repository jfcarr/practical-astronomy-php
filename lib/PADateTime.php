<?php

namespace PA\DateTime;

include 'PAMacros.php';
include 'PAUtils.php';

use PA\Macros as PA_Macros;
use PA\Utils as PA_Utils;

/**
 * Calculates the date of Easter for the year specified.
 */
function get_date_of_easter($inputYear)
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
function civil_date_to_day_number($month, $day, $year)
{
    if ($month <= 2) {
        $month = $month - 1;
        $month = (PA_Utils\is_leap_year($year)) ? $month * 62 : $month * 63;
        $month = floor((int)((float)$month / 2));
    } else {
        $month = floor((int)(((float)$month + 1) * 30.6));
        $month = (PA_Utils\is_leap_year($year)) ? $month - 62 : $month - 63;
    }

    return $month + $day;
}


/**
 * Convert a Civil Time (hours,minutes,seconds) to Decimal Hours
 */
function civil_time_to_decimal_hours($hours, $minutes, $seconds)
{
    return PA_Macros\hours_minutes_seconds_to_decimal_hours($hours, $minutes, $seconds);
}

/**
 * Convert Decimal Hours to Civil Time
 */
function decimal_hours_to_civil_time($decimalHours)
{
    $hours = PA_Macros\decimal_hours_hour($decimalHours);
    $minutes = PA_Macros\decimal_hours_minute($decimalHours);
    $seconds = PA_Macros\decimal_hours_second($decimalHours);

    return array($hours, $minutes, $seconds);
}

/**
 * Convert local Civil Time to Universal Time
 */
function local_civil_time_to_universal_time($lctHours, $lctMinutes, $lctSeconds, $isDaylightSavings, $zoneCorrection, $localDay, $localMonth, $localYear)
{
    $lct = civil_time_to_decimal_hours($lctHours, $lctMinutes, $lctSeconds);

    $daylightSavingsOffset = ($isDaylightSavings) ? 1 : 0;

    $utInterim = $lct - $daylightSavingsOffset - $zoneCorrection;
    $gdayInterim = $localDay + ($utInterim / 24);

    $jd = PA_Macros\civil_date_to_julian_date($gdayInterim, $localMonth, $localYear);

    $gDay = PA_Macros\julian_date_day($jd);
    $gMonth = PA_Macros\julian_date_month($jd);
    $gYear = PA_Macros\julian_date_year($jd);

    $ut = 24 * ($gDay - floor($gDay));

    $returnValue = array(
        PA_Macros\decimal_hours_hour($ut),
        PA_Macros\decimal_hours_minute($ut),
        (int)PA_Macros\decimal_hours_second($ut),
        (int)floor($gDay),
        $gMonth,
        $gYear
    );

    return $returnValue;
}

/**
 * Convert Universal Time to local Civil Time
 */
function universal_time_to_local_civil_time($utHours, $utMinutes, $utSeconds, $isDaylightSavings, $zoneCorrection, $gwDay, $gwMonth, $gwYear)
{
    $dstValue = ($isDaylightSavings) ? 1 : 0;
    $ut = PA_Macros\hours_minutes_seconds_to_decimal_hours($utHours, $utMinutes, $utSeconds);
    $zoneTime = $ut + $zoneCorrection;
    $localTime = $zoneTime + $dstValue;
    $localJDPlusLocalTime = PA_Macros\civil_date_to_julian_date($gwDay, $gwMonth, $gwYear) + ($localTime / 24);
    $localDay = PA_Macros\julian_date_day($localJDPlusLocalTime);
    $integerDay = floor($localDay);
    $localMonth = PA_Macros\julian_date_month($localJDPlusLocalTime);
    $localYear = PA_Macros\julian_date_year($localJDPlusLocalTime);

    $lct = 24 * ($localDay - $integerDay);

    return array(
        PA_Macros\decimal_hours_hour($lct),
        PA_Macros\decimal_hours_minute($lct),
        (int) PA_Macros\decimal_hours_second($lct),
        (int) $integerDay,
        $localMonth,
        $localYear
    );
}

/**
 * Convert Universal Time to Greenwich Sidereal Time
 */
function universal_time_to_greenwich_sidereal_time($utHours, $utMinutes, $utSeconds, $gwDay, $gwMonth, $gwYear)
{
    $jd = PA_Macros\civil_date_to_julian_date($gwDay, $gwMonth, $gwYear);
    $s = $jd - 2451545;
    $t = $s / 36525;
    $t01 = 6.697374558 + (2400.051336 * $t) + (0.000025862 * $t * $t);
    $t02 = $t01 - (24.0 * floor($t01 / 24));
    $ut = PA_Macros\hours_minutes_seconds_to_decimal_hours($utHours, $utMinutes, $utSeconds);
    $a = $ut * 1.002737909;
    $gst1 = $t02 + $a;
    $gst2 = $gst1 - (24.0 * floor($gst1 / 24));

    $gstHours = PA_Macros\decimal_hours_hour($gst2);
    $gstMinutes = PA_Macros\decimal_hours_minute($gst2);
    $gstSeconds = PA_Macros\decimal_hours_second($gst2);

    return array($gstHours, $gstMinutes, $gstSeconds);
}

/**
 * Convert Greenwich Sidereal Time to Universal Time
 */
function greenwich_sidereal_time_to_universal_time($gstHours, $gstMinutes, $gstSeconds, $gwDay, $gwMonth, $gwYear)
{
    $jd = PA_Macros\civil_date_to_julian_date($gwDay, $gwMonth, $gwYear);
    $s = $jd - 2451545;
    $t = $s / 36525;
    $t01 = 6.697374558 + (2400.051336 * $t) + (0.000025862 * $t * $t);
    $t02 = $t01 - (24 * floor($t01 / 24));
    $gstHours1 = PA_Macros\hours_minutes_seconds_to_decimal_hours($gstHours, $gstMinutes, $gstSeconds);

    $a = $gstHours1 - $t02;
    $b = $a - (24 * floor($a / 24));
    $ut = $b * 0.9972695663;
    $utHours = PA_Macros\decimal_hours_hour($ut);
    $utMinutes = PA_Macros\decimal_hours_minute($ut);
    $utSeconds = PA_Macros\decimal_hours_second($ut);

    $warningFlag = ($ut < 0.065574) ? "Warning" : "OK";

    return array($utHours, $utMinutes, $utSeconds, $warningFlag);
}

/**
 * Convert Greenwich Sidereal Time to Local Sidereal Time
 */
function greenwich_sidereal_time_to_local_sidereal_time($gstHours, $gstMinutes, $gstSeconds, $geographicalLongitude)
{
    $gst = PA_Macros\hours_minutes_seconds_to_decimal_hours($gstHours, $gstMinutes, $gstSeconds);
    $offset = $geographicalLongitude / 15;  // Convert longitude to hours

    // Handle negative longitudes
    if ($offset < 0) {
        $offset += 24;
    }

    $lstHours1 = $gst + $offset;
    $lstHours2 = $lstHours1 - (24 * floor($lstHours1 / 24));

    $lstHours = PA_Macros\decimal_hours_hour($lstHours2);
    $lstMinutes = PA_Macros\decimal_hours_minute($lstHours2);
    $lstSeconds = PA_Macros\decimal_hours_second($lstHours2);

    return array($lstHours, $lstMinutes, $lstSeconds);
}

/**
 * Convert Local Sidereal Time to Greenwich Sidereal Time
 */
function local_sidereal_time_to_greenwich_sidereal_time($lstHours, $lstMinutes, $lstSeconds, $geographicalLongitude)
{
    $gst = PA_Macros\hours_minutes_seconds_to_decimal_hours($lstHours, $lstMinutes, $lstSeconds);
    $longHours = $geographicalLongitude / 15;
    $gst1 = $gst - $longHours;
    $gst2 = $gst1 - (24 * floor($gst1 / 24));

    $gstHours = PA_Macros\decimal_hours_hour($gst2);
    $gstMinutes = PA_Macros\decimal_hours_minute($gst2);
    $gstSeconds = PA_Macros\decimal_hours_second($gst2);

    return array($gstHours, $gstMinutes, $gstSeconds);
}
