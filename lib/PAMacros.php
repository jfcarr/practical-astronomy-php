<?php

namespace PA\Macros;

include 'PAMathExtensions.php';

use PA\MathExtensions as PA_Math;

/**
 * Convert a Greenwich Date/Civil Date (day,month,year) to Julian Date
 *
 * Original macro name: CDJD
 */
function civil_date_to_julian_date($day, $month, $year)
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
 * Return Degrees part of Decimal Degrees
 * 
 * Original macro name: DDDeg
 */
function decimal_degrees_degrees($decimalDegrees)
{
    $a = abs($decimalDegrees);
    $b = $a * 3600;
    $c = round($b - 60 * floor($b / 60), 2);
    $e = ($c == 60) ? 60 : $b;

    return ($decimalDegrees < 0)
        ? -floor($e / 3600)
        : floor($e / 3600);
}

/**
 * Return Minutes part of Decimal Degrees
 * 
 * Original macro name: DDMin
 */
function decimal_degrees_minutes(float $decimalDegrees)
{
    $a = abs($decimalDegrees);
    $b = $a * 3600;
    $c = round($b - 60 * floor($b / 60), 2);
    $e = ($c == 60) ? $b + 60 : $b;

    return floor($e / 60) % 60;
}

/**
 * Return Seconds part of Decimal Degrees
 * 
 * Original macro name: DDSec
 */
function decimal_degrees_seconds($decimalDegrees)
{
    $a = abs($decimalDegrees);
    $b = $a * 3600;
    $c = round($b - 60 * floor($b / 60), 2);
    $d = ($c == 60) ? 0 : $c;

    return $d;
}

/**
 * Return the hour part of a Decimal Hours
 * 
 * Original macro name: DHHour
 */
function decimal_hours_hour($decimalHours)
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
function decimal_hours_minute($decimalHours)
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
function decimal_hours_second($decimalHours)
{
    $a = abs($decimalHours);
    $b = $a * 3600;
    $c = round($b - 60 * floor($b / 60), 2);
    $d = ($c == 60) ? 0 : $c;

    return $d;
}

/**
 * Convert Degrees Minutes Seconds to Decimal Degrees
 * 
 * Original macro name: DMSDD
 */
function degrees_minutes_seconds_to_decimal_degrees($degrees, $minutes, $seconds)
{
    // Calculate the decimal portions of minutes and seconds
    $a = abs($seconds) / 60;
    $b = (abs($minutes) + $a) / 60;
    $c = abs($degrees) + $b;

    // Apply negative sign if any input was negative
    return ($degrees < 0 || $minutes < 0 || $seconds < 0) ? -$c : $c;
}

/**
 * Convert Equatorial Coordinates to Altitude (in decimal degrees)
 * 
 * Original macro name: EQAlt
 */
function equatorial_coordinates_to_altitude($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $declinationDegrees, $declinationMinutes, $declinationSeconds, $geographicalLatitude)
{
    $a = hours_minutes_seconds_to_decimal_hours($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds);
    $b = $a * 15;
    $c = PA_Math\degrees_to_radians($b);
    $d = degrees_minutes_seconds_to_decimal_degrees($declinationDegrees, $declinationMinutes, $declinationSeconds);
    $e = PA_Math\degrees_to_radians($d);
    $f = PA_Math\degrees_to_radians($geographicalLatitude);
    $g = sin($e) * sin($f) + cos($e) * cos($f) * cos($c);

    return degrees(asin($g));
}

/**
 * Convert Equatorial Coordinates to Azimuth (in decimal degrees)
 * 
 * Original macro name: EQAz
 */
function equatorial_coordinates_to_azimuth($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $declinationDegrees, $declinationMinutes, $declinationSeconds, $geographicalLatitude)
{
    $a = hours_minutes_seconds_to_decimal_hours($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds);
    $b = $a * 15;
    $c = PA_Math\degrees_to_radians($b);
    $d = degrees_minutes_seconds_to_decimal_degrees($declinationDegrees, $declinationMinutes, $declinationSeconds);
    $e = PA_Math\degrees_to_radians($d);
    $f = PA_Math\degrees_to_radians($geographicalLatitude);
    $g = sin($e) * sin($f) + cos($e) * cos($f) * cos($c);
    $h = -cos($e) * cos($f) * sin($c);
    $i = sin($e) - (sin($f) * $g);
    $j = degrees(atan2($h, $i));

    return $j - 360.0 * floor($j / 360);
}

/**
 * Convert Greenwich Sidereal Time to Local Sidereal Time
 * 
 * Original macro name: GSTLST
 */
function greenwich_sidereal_time_to_local_sidereal_time($greenwichHours, $greenwichMinutes, $greenwichSeconds, $geographicalLongitude)
{
    $a = hours_minutes_seconds_to_decimal_hours($greenwichHours, $greenwichMinutes, $greenwichSeconds);
    $b = $geographicalLongitude / 15;
    $c = $a + $b;

    return $c - (24 * floor($c / 24));
}

/**
 * Convert Horizon Coordinates to Declination (in decimal degrees)
 *
 * Original macro name: HORDec
 */
function horizon_coordinates_to_declination($azimuthDegrees, $azimuthMinutes, $azimuthSeconds, $altitudeDegrees, $altitudeMinutes, $altitudeSeconds, $geographicalLatitude)
{
    $a = degrees_minutes_seconds_to_decimal_degrees($azimuthDegrees, $azimuthMinutes, $azimuthSeconds);
    $b = degrees_minutes_seconds_to_decimal_degrees($altitudeDegrees, $altitudeMinutes, $altitudeSeconds);
    $c = PA_Math\degrees_to_radians($a);
    $d = PA_Math\degrees_to_radians($b);
    $e = PA_Math\degrees_to_radians($geographicalLatitude);
    $f = sin($d) * sin($e) + cos($d) * cos($e) * cos($c);

    return degrees(asin($f));
}

/**
 * Convert Horizon Coordinates to Hour Angle (in decimal degrees)
 *
 * Original macro name: HORHa
 */
function horizon_coordinates_to_hour_angle($azimuthDegrees, $azimuthMinutes, $azimuthSeconds, $altitudeDegrees, $altitudeMinutes, $altitudeSeconds, $geographicalLatitude)
{
    $a = degrees_minutes_seconds_to_decimal_degrees($azimuthDegrees, $azimuthMinutes, $azimuthSeconds);
    $b = degrees_minutes_seconds_to_decimal_degrees($altitudeDegrees, $altitudeMinutes, $altitudeSeconds);
    $c = PA_Math\degrees_to_radians($a);
    $d = PA_Math\degrees_to_radians($b);
    $e = PA_Math\degrees_to_radians($geographicalLatitude);
    $f = sin($d) * sin($e) + cos($d) * cos($e) * cos($c);
    $g = -cos($d) * cos($e) * sin($c);
    $h = sin($d) - sin($e) * $f;
    $i = decimal_degrees_to_degree_hours(degrees(atan2($g, $h)));

    return $i - 24 * floor($i / 24);
}

/**
 * Convert Decimal Degrees to Degree-Hours
 *
 * Original macro name: DDDH
 */
function decimal_degrees_to_degree_hours($decimalDegrees)
{
    return $decimalDegrees / 15;
}


/**
 * 
 * Convert W to Degrees
 *
 * Original macro name: Degrees
 */
function degrees($w)
{
    return $w * 57.29577951;
}

/**
 * Convert Hour Angle to Right Ascension
 * 
 * Original macro name: HARA
 */
function hour_angle_to_right_ascension($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear, $geographicalLongitude)
{
    $a = local_civil_time_to_universal_time($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $b = local_civil_time_greenwich_day($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $c = local_civil_time_greenwich_month($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $d = local_civil_time_greenwich_year($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $e = universal_time_to_greenwich_sidereal_time($a, 0, 0, $b, $c, $d);
    $f = greenwich_sidereal_time_to_local_sidereal_time($e, 0, 0, $geographicalLongitude);

    $g = hours_minutes_seconds_to_decimal_hours($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds);
    $h = $f - $g;

    return ($h < 0) ? 24 + $h : $h;
}

/**
 * Convert a Civil Time (hours,minutes,seconds) to Decimal Hours
 * 
 * Original macro name: HMSDH
 */
function hours_minutes_seconds_to_decimal_hours($hours,  $minutes,  $seconds)
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
 * Returns the day part of a Julian Date
 *
 * Original macro name: JDCDay
 */
function julian_date_day($julianDate)
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
function julian_date_month($julianDate)
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
function julian_date_year($julianDate)
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

/**
 * Determine Greenwich Day for Local Time
 * 
 * Original macro name: LctGDay
 */
function local_civil_time_greenwich_day($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear)
{
    $a = hours_minutes_seconds_to_decimal_hours($lctHours, $lctMinutes, $lctSeconds);
    $b = $a - $daylightSaving - $zoneCorrection;
    $c = $localDay + ($b / 24);
    $d = civil_date_to_julian_date($c, $localMonth, $localYear);
    $e = julian_date_day($d);

    return floor($e);
}

/**
 * Determine Greenwich Month for Local Time
 * 
 * Original macro name: LctGMonth
 */
function local_civil_time_greenwich_month($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear)
{
    $a = hours_minutes_seconds_to_decimal_hours($lctHours, $lctMinutes, $lctSeconds);
    $b = $a - $daylightSaving - $zoneCorrection;
    $c = $localDay + ($b / 24);
    $d = civil_date_to_julian_date($c, $localMonth, $localYear);

    return julian_date_month($d);
}

/**
 * Determine Greenwich Year for Local Time
 * 
 * Original macro name: LctGYear
 * 
 */
function local_civil_time_greenwich_year($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear)
{
    $a = hours_minutes_seconds_to_decimal_hours($lctHours, $lctMinutes, $lctSeconds);
    $b = $a - $daylightSaving - $zoneCorrection;
    $c = $localDay + ($b / 24);
    $d = civil_date_to_julian_date($c, $localMonth, $localYear);

    return julian_date_year($d);
}

/**
 * Convert Local Civil Time to Universal Time
 * 
 * Original macro name: LctUT
 */
function local_civil_time_to_universal_time($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear)
{
    $a = hours_minutes_seconds_to_decimal_hours($lctHours, $lctMinutes, $lctSeconds);
    $b = $a - $daylightSaving - $zoneCorrection;
    $c = $localDay + ($b / 24);

    $d = civil_date_to_julian_date($c, $localMonth, $localYear);

    $e = julian_date_day($d);
    $e1 = floor($e);

    return 24 * ($e - $e1);
}

/**
 * Convert Right Ascension to Hour Angle
 * 
 * Original macro name: RAHA
 */
function right_ascension_to_hour_angle($raHours, $raMinutes, $raSeconds, $lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear, $geographicalLongitude)
{
    $a = local_civil_time_to_universal_time($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $b = local_civil_time_greenwich_day($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $c = local_civil_time_greenwich_month($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $d = local_civil_time_greenwich_year($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $e = universal_time_to_greenwich_sidereal_time($a, 0, 0, $b, $c, $d);
    $f = greenwich_sidereal_time_to_local_sidereal_time($e, 0, 0, $geographicalLongitude);

    $g = hours_minutes_seconds_to_decimal_hours($raHours, $raMinutes, $raSeconds);
    $h = $f - $g;

    return ($h < 0) ? 24 + $h : $h;
}

/**
 * Convert Universal Time to Greenwich Sidereal Time
 * 
 * Original macro name: UTGST
 */
function universal_time_to_greenwich_sidereal_time($uHours, $uMinutes, $uSeconds, $greenwichDay, $greenwichMonth, $greenwichYear)
{
    $a =  civil_date_to_julian_date($greenwichDay, $greenwichMonth, $greenwichYear);
    $b = $a - 2451545;
    $c = $b / 36525;
    $d = 6.697374558 + (2400.051336 * $c) + (0.000025862 * $c * $c);
    $e = $d - floor($d / 24) * 24;

    $f = $uHours + $uMinutes / 60 + $uSeconds / 3600;
    $g = $f * 1.002737909;
    $h = $e + $g;

    return $h - floor($h / 24) * 24;
}
