<?php

namespace PA\Macros;

include_once 'PAMathExtensions.php';
include_once 'PATypes.php';

use PA\MathExtensions as PA_Math;
use PA\Types as PA_Types;

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

/**
 * Obliquity of the Ecliptic for a Greenwich Date
 *
 * Original macro name: Obliq
 */
function obliq($greenwichDay, $greenwichMonth, $greenwichYear)
{
    $a = civil_date_to_julian_date($greenwichDay, $greenwichMonth, $greenwichYear);
    $b = $a - 2415020;
    $c = ($b / 36525) - 1;
    $d = $c * (46.815 + $c * (0.0006 - ($c * 0.00181)));
    $e = $d / 3600;

    return 23.43929167 - $e + nutat_obl($greenwichDay, $greenwichMonth, $greenwichYear);
}

/**
 * Nutation amount to be added in ecliptic longitude, in degrees.
 *
 * Original macro name: NutatLong
 */
function nutat_long($gd, $gm, $gy)
{
    $dj = civil_date_to_julian_date($gd, $gm, $gy) - 2415020;
    $t = $dj / 36525;
    $t2 = $t * $t;

    $a = 100.0021358 * $t;
    $b = 360 * ($a - floor($a));

    $l1 = 279.6967 + 0.000303 * $t2 + $b;
    $l2 = 2 * PA_Math\degrees_to_radians($l1);

    $a = 1336.855231 * $t;
    $b = 360 * ($a - floor($a));

    $d1 = 270.4342 - 0.001133 * $t2 + $b;
    $d2 = 2 * PA_Math\degrees_to_radians($d1);

    $a = 99.99736056 * $t;
    $b = 360 * ($a - floor($a));

    $m1 = 358.4758 - 0.00015 * $t2 + $b;
    $m1 = PA_Math\degrees_to_radians($m1);

    $a = 1325.552359 * $t;
    $b = 360 * ($a - floor($a));

    $m2 = 296.1046 + 0.009192 * $t2 + $b;
    $m2 = PA_Math\degrees_to_radians($m2);

    $a = 5.372616667 * $t;
    $b = 360 * ($a - floor($a));

    $n1 = 259.1833 + 0.002078 * $t2 - $b;
    $n1 = PA_Math\degrees_to_radians($n1);

    $n2 = 2.0 * $n1;

    $dp = (-17.2327 - 0.01737 * $t) * sin($n1);
    $dp = $dp + (-1.2729 - 0.00013 * $t) * sin($l2)  + 0.2088 * sin($n2);
    $dp = $dp - 0.2037 * sin($d2) + (0.1261 - 0.00031 * $t) * sin($m1);
    $dp = $dp + 0.0675 * sin($m2) - (0.0497 - 0.00012 * $t) * sin($l2 + $m1);
    $dp = $dp - 0.0342 * sin($d2 - $n1) - 0.0261 * sin($d2 + $m2);
    $dp = $dp + 0.0214 * sin($l2 - $m1) - 0.0149 * sin($l2 - $d2 + $m2);
    $dp = $dp + 0.0124 * sin($l2 - $n1) + 0.0114 * sin($d2 - $m2);

    return $dp / 3600;
}

/**
 * Nutation of Obliquity
 *
 * Original macro name: NutatObl
 */
function nutat_obl($greenwichDay, $greenwichMonth, $greenwichYear)
{
    $dj = civil_date_to_julian_date($greenwichDay, $greenwichMonth, $greenwichYear) - 2415020;
    $t = $dj / 36525;
    $t2 = $t * $t;

    $a = 100.0021358 * $t;
    $b = 360 * ($a - floor($a));

    $l1 = 279.6967 + 0.000303 * $t2 + $b;
    $l2 = 2 * PA_Math\degrees_to_radians($l1);

    $a = 1336.855231 * $t;
    $b = 360 * ($a - floor($a));

    $d1 = 270.4342 - 0.001133 * $t2 + $b;
    $d2 = 2 * PA_Math\degrees_to_radians($d1);

    $a = 99.99736056 * $t;
    $b = 360 * ($a - floor($a));

    $m1 = PA_Math\degrees_to_radians(358.4758 - 0.00015 * $t2 + $b);

    $a = 1325.552359 * $t;
    $b = 360 * ($a - floor($a));

    $m2 = PA_Math\degrees_to_radians(296.1046 + 0.009192 * $t2 + $b);

    $a = 5.372616667 * $t;
    $b = 360 * ($a - floor($a));

    $n1 = PA_Math\degrees_to_radians(259.1833 + 0.002078 * $t2 - $b);

    $n2 = 2 * $n1;

    $ddo = (9.21 + 0.00091 * $t) * cos($n1);
    $ddo += (0.5522 - 0.00029 * $t) * cos($l2) - 0.0904 * cos($n2);
    $ddo += 0.0884 * cos($d2) + 0.0216 * cos($l2 + $m1);
    $ddo += 0.0183 * cos($d2 - $n1) + 0.0113 * cos($d2 + $m2);
    $ddo -= 0.0093 * cos($l2 - $m1) - 0.0066 * cos($l2 - $n1);

    return $ddo / 3600;
}

/**
 * Convert Degree-Hours to Decimal Degrees
 *
 * Original macro name: DHDD
 */
function degree_hours_to_decimal_degrees($degreeHours)
{
    return $degreeHours * 15;
}

/**
 * Convert Greenwich Sidereal Time to Universal Time
 *
 * Original macro name: GSTUT
 */
function greenwich_sidereal_time_to_universal_time($greenwichSiderealHours, $greenwichSiderealMinutes, $greenwichSiderealSeconds, $greenwichDay, $greenwichMonth, $greenwichYear)
{
    $a = civil_date_to_julian_date($greenwichDay, $greenwichMonth, $greenwichYear);
    $b = $a - 2451545;
    $c = $b / 36525;
    $d = 6.697374558 + (2400.051336 * $c) + (0.000025862 * $c * $c);
    $e = $d - (24 * floor($d / 24));
    $f = hours_minutes_seconds_to_decimal_hours($greenwichSiderealHours, $greenwichSiderealMinutes, $greenwichSiderealSeconds);
    $g = $f - $e;
    $h = $g - (24 * floor($g / 24));

    return $h * 0.9972695663;
}

/**
 * Convert Local Sidereal Time to Greenwich Sidereal Time
 *
 * Original macro name: LSTGST
 */
function local_sidereal_time_to_greenwich_sidereal_time($localHours, $localMinutes, $localSeconds, $longitude)
{
    $a = hours_minutes_seconds_to_decimal_hours($localHours, $localMinutes, $localSeconds);
    $b = $longitude / 15;
    $c = $a - $b;

    return $c - (24 * floor($c / 24));
}

/**
 * Calculate Sun's ecliptic longitude
 *
 * Original macro name: SunLong
 */
function sun_long($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly)
{
    $aa = local_civil_time_greenwich_day($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly);
    $bb = local_civil_time_greenwich_month($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly);
    $cc = local_civil_time_greenwich_year($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly);
    $ut = local_civil_time_to_universal_time($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly);
    $dj = civil_date_to_julian_date($aa, $bb, $cc) - 2415020;
    $t = ($dj / 36525) + ($ut / 876600);
    $t2 = $t * $t;
    $a = 100.0021359 * $t;
    $b = 360.0 * ($a - floor($a));

    $l = 279.69668 + 0.0003025 * $t2 + $b;
    $a = 99.99736042 * $t;
    $b = 360 * ($a - floor($a));

    $m1 = 358.47583 - (0.00015 + 0.0000033 * $t) * $t2 + $b;
    $ec = 0.01675104 - 0.0000418 * $t - 0.000000126 * $t2;

    $am = PA_Math\degrees_to_radians($m1);
    $at = true_anomaly($am, $ec);

    $a = 62.55209472 * $t;
    $b = 360 * ($a - floor($a));

    $a1 = PA_Math\degrees_to_radians(153.23 + $b);
    $a = 125.1041894 * $t;
    $b = 360 * ($a - floor($a));

    $b1 = PA_Math\degrees_to_radians(216.57 + $b);
    $a = 91.56766028 * $t;
    $b = 360.0 * ($a - floor($a));

    $c1 = PA_Math\degrees_to_radians(312.69 + $b);
    $a = 1236.853095 * $t;
    $b = 360.0 * ($a - floor($a));

    $d1 = PA_Math\degrees_to_radians(350.74 - 0.00144 * $t2 + $b);
    $e1 = PA_Math\degrees_to_radians(231.19 + 20.2 * $t);
    $a = 183.1353208 * $t;
    $b = 360.0 * ($a - floor($a));
    $h1 = PA_Math\degrees_to_radians(353.4 + $b);

    $d2 = 0.00134 * cos($a1) + 0.00154 * cos($b1) + 0.002 * cos($c1);
    $d2 = $d2 + 0.00179 * sin($d1) + 0.00178 * sin($e1);
    $d3 = 0.00000543 * sin($a1) + 0.00001575 * sin($b1);
    $d3 = $d3 + 0.00001627 * sin($c1) + 0.00003076 * cos($d1);

    $sr = $at + PA_Math\degrees_to_radians($l - $m1 + $d2);
    $tp = 6.283185308;

    $sr = $sr - $tp * floor($sr / $tp);

    return degrees($sr);
}

/**
 * Solve Kepler's equation, and return value of the true anomaly in radians
 *
 * Original macro name: TrueAnomaly
 */
function true_anomaly($am, $ec)
{
    $tp = 6.283185308;
    $m = $am - $tp * floor($am / $tp);
    $ae = $m;

    while (1 == 1) {
        $d = $ae - ($ec * sin($ae)) - $m;
        if (abs($d) < 0.000001) {
            break;
        }
        $d = $d / (1.0 - ($ec * cos($ae)));
        $ae = $ae - $d;
    }
    $a = sqrt((1 + $ec) / (1 - $ec)) * tan($ae / 2);
    $at = 2.0 * atan($a);

    return $at;
}

/**
 * Solve Kepler's equation, and return value of the eccentric anomaly in radians
 *
 * Original macro name: EccentricAnomaly
 */
function eccentric_anomaly($am, $ec)
{
    $tp = 6.283185308;
    $m = $am - $tp * floor($am / $tp);
    $ae = $m;

    while (1 == 1) {
        $d = $ae - ($ec * sin($ae)) - $m;

        if (abs($d) < 0.000001) {
            break;
        }

        $d = $d / (1 - ($ec * cos($ae)));
        $ae = $ae - $d;
    }

    return $ae;
}

/**
 * Calculate effects of refraction
 *
 * Original macro name: Refract
 */
function refract($y2, PA_Types\CoordinateType $sw, $pr, $tr)
{
    $y = PA_Math\degrees_to_radians($y2);

    $d = ($sw == PA_Types\CoordinateType::True) ? -1.0 : 1.0;

    if ($d == -1) {
        $y3 = $y;
        $y1 = $y;
        $r1 = 0.0;

        while (1 == 1) {
            $yNew = $y1 + $r1;
            $rfNew = refract_l3035($pr, $tr, $yNew, $d);

            if ($y < -0.087)
                return 0;

            $r2 = $rfNew;

            if (($r2 == 0) || (abs($r2 - $r1) < 0.000001)) {
                $qNew = $y3;

                return degrees($qNew + $rfNew);
            }

            $r1 = $r2;
        }
    }

    $rf = refract_l3035($pr, $tr, $y, $d);

    if ($y < -0.087)
        return 0;

    $q = $y;

    return degrees($q + $rf);
}

/**
 * Helper function for refract
 */
function refract_l3035($pr, $tr, $y, $d)
{
    if ($y < 0.2617994) {
        if ($y < -0.087)
            return 0;

        $yd = degrees($y);
        $a = ((0.00002 * $yd + 0.0196) * $yd + 0.1594) * $pr;
        $b = (273.0 + $tr) * ((0.0845 * $yd + 0.505) * $yd + 1);

        return PA_Math\degrees_to_radians(- ($a / $b) * $d);
    }

    return -$d * 0.00007888888 * $pr / ((273.0 + $tr) * tan($y));
}
