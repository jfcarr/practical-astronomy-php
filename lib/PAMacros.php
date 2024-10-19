<?php

namespace PA\Macros;

include_once 'PATypes.php';

use PA\Types as PA_Types;
use PA\Types\RiseSetStatus;
use PA\Types\WarningFlag;

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
    $c = deg2rad($b);
    $d = degrees_minutes_seconds_to_decimal_degrees($declinationDegrees, $declinationMinutes, $declinationSeconds);
    $e = deg2rad($d);
    $f = deg2rad($geographicalLatitude);
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
    $c = deg2rad($b);
    $d = degrees_minutes_seconds_to_decimal_degrees($declinationDegrees, $declinationMinutes, $declinationSeconds);
    $e = deg2rad($d);
    $f = deg2rad($geographicalLatitude);
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
    $c = deg2rad($a);
    $d = deg2rad($b);
    $e = deg2rad($geographicalLatitude);
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
    $c = deg2rad($a);
    $d = deg2rad($b);
    $e = deg2rad($geographicalLatitude);
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
 * Convert Universal Time to Local Civil Time
 * 
 * Original macro name: UTLct
 */
function universal_time_to_local_civil_time($uHours, $uMinutes, $uSeconds, $daylightSaving, $zoneCorrection, $greenwichDay, $greenwichMonth, $greenwichYear)
{
    $a = hours_minutes_seconds_to_decimal_hours($uHours, $uMinutes, $uSeconds);
    $b = $a + $zoneCorrection;
    $c = $b + $daylightSaving;
    $d = civil_date_to_julian_date($greenwichDay, $greenwichMonth, $greenwichYear) + ($c / 24);
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
    $l2 = 2 * deg2rad($l1);

    $a = 1336.855231 * $t;
    $b = 360 * ($a - floor($a));

    $d1 = 270.4342 - 0.001133 * $t2 + $b;
    $d2 = 2 * deg2rad($d1);

    $a = 99.99736056 * $t;
    $b = 360 * ($a - floor($a));

    $m1 = 358.4758 - 0.00015 * $t2 + $b;
    $m1 = deg2rad($m1);

    $a = 1325.552359 * $t;
    $b = 360 * ($a - floor($a));

    $m2 = 296.1046 + 0.009192 * $t2 + $b;
    $m2 = deg2rad($m2);

    $a = 5.372616667 * $t;
    $b = 360 * ($a - floor($a));

    $n1 = 259.1833 + 0.002078 * $t2 - $b;
    $n1 = deg2rad($n1);

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
    $l2 = 2 * deg2rad($l1);

    $a = 1336.855231 * $t;
    $b = 360 * ($a - floor($a));

    $d1 = 270.4342 - 0.001133 * $t2 + $b;
    $d2 = 2 * deg2rad($d1);

    $a = 99.99736056 * $t;
    $b = 360 * ($a - floor($a));

    $m1 = deg2rad(358.4758 - 0.00015 * $t2 + $b);

    $a = 1325.552359 * $t;
    $b = 360 * ($a - floor($a));

    $m2 = deg2rad(296.1046 + 0.009192 * $t2 + $b);

    $a = 5.372616667 * $t;
    $b = 360 * ($a - floor($a));

    $n1 = deg2rad(259.1833 + 0.002078 * $t2 - $b);

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
 * Status of conversion of Greenwich Sidereal Time to Universal Time.
 * 
 * Original macro name: eGSTUT
 */
function eg_st_ut($gsh, $gsm, $gss, $gd, $gm, $gy)
{
    $a = civil_date_to_julian_date($gd, $gm, $gy);
    $b = $a - 2451545;
    $c = $b / 36525;
    $d = 6.697374558 + (2400.051336 * $c) + (0.000025862 * $c * $c);
    $e = $d - (24 * floor($d / 24));
    $f = hours_minutes_seconds_to_decimal_hours($gsh, $gsm, $gss);
    $g = $f - $e;
    $h = $g - (24 * floor($g / 24));

    return (($h * 0.9972695663) < (4.0 / 60.0)) ? WarningFlag::Warning : WarningFlag::OK;
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

    $am = deg2rad($m1);
    $at = true_anomaly($am, $ec);

    $a = 62.55209472 * $t;
    $b = 360 * ($a - floor($a));

    $a1 = deg2rad(153.23 + $b);
    $a = 125.1041894 * $t;
    $b = 360 * ($a - floor($a));

    $b1 = deg2rad(216.57 + $b);
    $a = 91.56766028 * $t;
    $b = 360.0 * ($a - floor($a));

    $c1 = deg2rad(312.69 + $b);
    $a = 1236.853095 * $t;
    $b = 360.0 * ($a - floor($a));

    $d1 = deg2rad(350.74 - 0.00144 * $t2 + $b);
    $e1 = deg2rad(231.19 + 20.2 * $t);
    $a = 183.1353208 * $t;
    $b = 360.0 * ($a - floor($a));
    $h1 = deg2rad(353.4 + $b);

    $d2 = 0.00134 * cos($a1) + 0.00154 * cos($b1) + 0.002 * cos($c1);
    $d2 = $d2 + 0.00179 * sin($d1) + 0.00178 * sin($e1);
    $d3 = 0.00000543 * sin($a1) + 0.00001575 * sin($b1);
    $d3 = $d3 + 0.00001627 * sin($c1) + 0.00003076 * cos($d1);

    $sr = $at + deg2rad($l - $m1 + $d2);
    $tp = 6.283185308;

    $sr = $sr - $tp * floor($sr / $tp);

    return degrees($sr);
}

/**
 * Calculate Sun's angular diameter in decimal degrees
 *
 * Original macro name: SunDia
 */
function sun_dia($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly)
{
    $a = sun_dist($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly);

    return 0.533128 / $a;
}

/**
 * Calculate Sun's distance from the Earth in astronomical units
 *
 * Original macro name: SunDist
 */
function sun_dist($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly)
{
    $aa = local_civil_time_greenwich_day($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly);
    $bb = local_civil_time_greenwich_month($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly);
    $cc = local_civil_time_greenwich_year($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly);
    $ut = local_civil_time_to_universal_time($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly);
    $dj = civil_date_to_julian_date($aa, $bb, $cc) - 2415020;

    $t = ($dj / 36525) + ($ut / 876600);
    $t2 = $t * $t;

    $a = 100.0021359 * $t;
    $b = 360 * ($a - floor($a));
    $a = 99.99736042 * $t;
    $b = 360 * ($a - floor($a));
    $m1 = 358.47583 - (0.00015 + 0.0000033 * $t) * $t2 + $b;
    $ec = 0.01675104 - 0.0000418 * $t - 0.000000126 * $t2;

    $am = deg2rad($m1);
    $ae = eccentric_anomaly($am, $ec);

    $a = 62.55209472 * $t;
    $b = 360 * ($a - floor($a));
    $a1 = deg2rad(153.23 + $b);
    $a = 125.1041894 * $t;
    $b = 360 * ($a - floor($a));
    $b1 = deg2rad(216.57 + $b);
    $a = 91.56766028 * $t;
    $b = 360 * ($a - floor($a));
    $c1 = deg2rad(312.69 + $b);
    $a = 1236.853095 * $t;
    $b = 360 * ($a - floor($a));
    $d1 = deg2rad(350.74 - 0.00144 * $t2 + $b);
    $e1 = deg2rad(231.19 + 20.2 * $t);
    $a = 183.1353208 * $t;
    $b = 360 * ($a - floor($a));
    $h1 = deg2rad(353.4 + $b);

    $d3 = (0.00000543 * sin($a1) + 0.00001575 * sin($b1)) + (0.00001627 * sin($c1) + 0.00003076 * cos($d1)) + (0.00000927 * sin($h1));

    return 1.0000002 * (1 - $ec * cos($ae)) + $d3;
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
    $y = deg2rad($y2);

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

        return deg2rad(- ($a / $b) * $d);
    }

    return -$d * 0.00007888888 * $pr / ((273.0 + $tr) * tan($y));
}

/**
 * Calculate corrected hour angle in decimal hours
 *
 * Original macro name: ParallaxHA
 */
function parallax_ha($hh, $hm, $hs, $dd, $dm, $ds, PA_Types\CoordinateType $sw, $gp, $ht, $hp)
{
    $a = deg2rad($gp);
    $c1 = cos($a);
    $s1 = sin($a);

    $u = atan(0.996647 * $s1 / $c1);
    $c2 = cos($u);
    $s2 = sin($u);
    $b = $ht / 6378160;

    $rs = (0.996647 * $s2) + ($b * $s1);

    $rc = $c2 + ($b * $c1);
    $tp = 6.283185308;

    $rp = 1.0 / sin(deg2rad($hp));

    $x = deg2rad(degree_hours_to_decimal_degrees(hours_minutes_seconds_to_decimal_hours($hh, $hm, $hs)));
    $x1 = $x;
    $y = deg2rad(degrees_minutes_seconds_to_decimal_degrees($dd, $dm, $ds));
    $y1 = $y;

    $d = ($sw == PA_Types\CoordinateType::True) ? 1.0 : -1.0;

    if ($d == 1) {
        list($p, $q) = parallax_ha_l2870($x, $y, $rc, $rp, $rs, $tp);

        return decimal_degrees_to_degree_hours(degrees($p));
    }

    $p1 = 0.0;
    $q1 = 0.0;
    $xLoop = $x;
    $yLoop = $y;

    while (1 == 1) {
        list($p, $q) = parallax_ha_l2870($xLoop, $yLoop, $rc, $rp, $rs, $tp);
        $p2 = $p - $xLoop;
        $q2 = $q - $yLoop;

        $aa = abs($p2 - $p1);
        $bb = abs($q2 - $q1);

        if (($aa < 0.000001) && ($bb < 0.000001)) {
            $p = $x1 - $p2;

            return decimal_degrees_to_degree_hours(degrees($p));
        }

        $xLoop = $x1 - $p2;
        $yLoop = $y1 - $q2;
        $p1 = $p2;
        $q1 = $q2;
    }
}

/**
 * Helper function for parallax_ha
 */
function parallax_ha_l2870($x, $y, $rc, $rp, $rs, $tp)
{
    $cx = cos($x);
    $sy = sin($y);
    $cy = cos($y);

    $aa = ($rc * sin($x)) / (($rp * $cy) - ($rc * $cx));

    $dx = atan($aa);
    $p = $x + $dx;
    $cp = cos($p);

    $p = $p - $tp * floor($p / $tp);
    $q = atan($cp * ($rp * $sy - $rs) / ($rp * $cy * $cx - $rc));

    return array($p, $q);
}

/**
 * Calculate corrected declination in decimal degrees
 *
 * Original macro name: ParallaxDec
 */
function parallax_dec($hh, $hm, $hs, $dd, $dm, $ds, PA_Types\CoordinateType $sw, $gp, $ht, $hp)
{
    $a = deg2rad($gp);
    $c1 = cos($a);
    $s1 = sin($a);

    $u = atan(0.996647 * $s1 / $c1);

    $c2 = cos($u);
    $s2 = sin($u);
    $b = $ht / 6378160;
    $rs = (0.996647 * $s2) + ($b * $s1);

    $rc = $c2 + ($b * $c1);
    $tp = 6.283185308;

    $rp = 1.0 / sin(deg2rad($hp));

    $x = deg2rad(degree_hours_to_decimal_degrees(hours_minutes_seconds_to_decimal_hours($hh, $hm, $hs)));
    $x1 = $x;

    $y = deg2rad(degrees_minutes_seconds_to_decimal_degrees($dd, $dm, $ds));
    $y1 = $y;

    $d = ($sw == PA_Types\CoordinateType::True) ? 1.0 : -1.0;

    if ($d == 1) {
        list($p, $q) = parallax_dec_l2870($x, $y, $rc, $rp, $rs, $tp);

        return degrees($q);
    }

    $p1 = 0.0;
    $q1 = 0.0;

    $xLoop = $x;
    $yLoop = $y;

    while (1 == 1) {
        list($p, $q) = parallax_dec_l2870($xLoop, $yLoop, $rc, $rp, $rs, $tp);
        $p2 = $p - $xLoop;
        $q2 = $q - $yLoop;
        $aa = abs($p2 - $p1);

        if (($aa < 0.000001) && ($b < 0.000001)) {
            $q = $y1 - $q2;

            return degrees($q);
        }
        $xLoop = $x1 - $p2;
        $yLoop = $y1 - $q2;
        $p1 = $p2;
        $q1 = $q2;
    }
}

/**
 * Helper function for parallax_dec
 */
function parallax_dec_l2870($x, $y, $rc, $rp, $rs, $tp)
{
    $cx = cos($x);
    $sy = sin($y);
    $cy = cos($y);

    $aa = ($rc * sin($x)) / (($rp * $cy) - ($rc * $cx));
    $dx = atan($aa);
    $p = $x + $dx;
    $cp = cos($p);

    $p = $p - $tp * floor($p / $tp);
    $q = atan($cp * ($rp * $sy - $rs) / ($rp * $cy * $cx - $rc));

    return array($p, $q);
}

/**
 * Calculate geocentric ecliptic longitude for the Moon
 *
 * Original macro name: MoonLong
 */
function moon_long($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr)
{
    $ut = local_civil_time_to_universal_time($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gd = local_civil_time_greenwich_day($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gm = local_civil_time_greenwich_month($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gy = local_civil_time_greenwich_year($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $t = ((civil_date_to_julian_date($gd, $gm, $gy) - 2415020) / 36525) + ($ut / 876600);
    $t2 = $t * $t;

    $m1 = 27.32158213;
    $m2 = 365.2596407;
    $m3 = 27.55455094;
    $m4 = 29.53058868;
    $m5 = 27.21222039;
    $m6 = 6798.363307;
    $q = civil_date_to_julian_date($gd, $gm, $gy) - 2415020 + ($ut / 24);
    $m1 = $q / $m1;
    $m2 = $q / $m2;
    $m3 = $q / $m3;
    $m4 = $q / $m4;
    $m5 = $q / $m5;
    $m6 = $q / $m6;
    $m1 = 360 * ($m1 - floor($m1));
    $m2 = 360 * ($m2 - floor($m2));
    $m3 = 360 * ($m3 - floor($m3));
    $m4 = 360 * ($m4 - floor($m4));
    $m5 = 360 * ($m5 - floor($m5));
    $m6 = 360 * ($m6 - floor($m6));

    $ml = 270.434164 + $m1 - (0.001133 - 0.0000019 * $t) * $t2;
    $ms = 358.475833 + $m2 - (0.00015 + 0.0000033 * $t) * $t2;
    $md = 296.104608 + $m3 + (0.009192 + 0.0000144 * $t) * $t2;
    $me1 = 350.737486 + $m4 - (0.001436 - 0.0000019 * $t) * $t2;
    $mf = 11.250889 + $m5 - (0.003211 + 0.0000003 * $t) * $t2;
    $na = 259.183275 - $m6 + (0.002078 + 0.0000022 * $t) * $t2;
    $a = deg2rad(51.2 + 20.2 * $t);
    $s1 = sin($a);
    $s2 = sin(deg2rad($na));
    $b = 346.56 + (132.87 - 0.0091731 * $t) * $t;
    $s3 = 0.003964 * sin(deg2rad($b));
    $c = deg2rad($na + 275.05 - 2.3 * $t);
    $s4 = sin($c);
    $ml = $ml + 0.000233 * $s1 + $s3 + 0.001964 * $s2;
    $ms = $ms - 0.001778 * $s1;
    $md = $md + 0.000817 * $s1 + $s3 + 0.002541 * $s2;
    $mf = $mf + $s3 - 0.024691 * $s2 - 0.004328 * $s4;
    $me1 = $me1 + 0.002011 * $s1 + $s3 + 0.001964 * $s2;
    $e = 1.0 - (0.002495 + 0.00000752 * $t) * $t;
    $e2 = $e * $e;
    $ml = deg2rad($ml);
    $ms = deg2rad($ms);
    $me1 = deg2rad($me1);
    $mf = deg2rad($mf);
    $md = deg2rad($md);

    $l = 6.28875 * sin($md) + 1.274018 * sin(2.0 * $me1 - $md);
    $l = $l + 0.658309 * sin(2.0 * $me1) + 0.213616 * sin(2.0 * $md);
    $l = $l - $e * 0.185596 * sin($ms) - 0.114336 * sin(2.0 * $mf);
    $l = $l + 0.058793 * sin(2.0 * ($me1 - $md));
    $l = $l + 0.057212 * $e * sin(2.0 * $me1 - $ms - $md) + 0.05332 * sin(2.0 * $me1 + $md);
    $l = $l + 0.045874 * $e * sin(2.0 * $me1 - $ms) + 0.041024 * $e * sin($md - $ms);
    $l = $l - 0.034718 * sin($me1) - $e * 0.030465 * sin($ms + $md);
    $l = $l + 0.015326 * sin(2.0 * ($me1 - $mf)) - 0.012528 * sin(2.0 * $mf + $md);
    $l = $l - 0.01098 * sin(2.0 * $mf - $md) + 0.010674 * sin(4.0 * $me1 - $md);
    $l = $l + 0.010034 * sin(3.0 * $md) + 0.008548 * sin(4.0 * $me1 - 2.0 * $md);
    $l = $l - $e * 0.00791 * sin($ms - $md + 2.0 * $me1) - $e * 0.006783 * sin(2.0 * $me1 + $ms);
    $l = $l + 0.005162 * sin($md - $me1) + $e * 0.005 * sin($ms + $me1);
    $l = $l + 0.003862 * sin(4.0 * $me1) + $e * 0.004049 * sin($md - $ms + 2.0 * $me1);
    $l = $l + 0.003996 * sin(2.0 * ($md + $me1)) + 0.003665 * sin(2.0 * $me1 - 3.0 * $md);
    $l = $l + $e * 0.002695 * sin(2.0 * $md - $ms) + 0.002602 * sin($md - 2.0 * ($mf + $me1));
    $l = $l + $e * 0.002396 * sin(2.0 * ($me1 - $md) - $ms) - 0.002349 * sin($md + $me1);
    $l = $l + $e2 * 0.002249 * sin(2.0 * ($me1 - $ms)) - $e * 0.002125 * sin(2.0 * $md + $ms);
    $l = $l - $e2 * 0.002079 * sin(2.0 * $ms) + $e2 * 0.002059 * sin(2.0 * ($me1 - $ms) - $md);
    $l = $l - 0.001773 * sin($md + 2.0 * ($me1 - $mf)) - 0.001595 * sin(2.0 * ($mf + $me1));
    $l = $l + $e * 0.00122 * sin(4.0 * $me1 - $ms - $md) - 0.00111 * sin(2.0 * ($md + $mf));
    $l = $l + 0.000892 * sin($md - 3.0 * $me1) - $e * 0.000811 * sin($ms + $md + 2.0 * $me1);
    $l = $l + $e * 0.000761 * sin(4.0 * $me1 - $ms - 2.0 * $md);
    $l = $l + $e2 * 0.000704 * sin($md - 2.0 * ($ms + $me1));
    $l = $l + $e * 0.000693 * sin($ms - 2.0 * ($md - $me1));
    $l = $l + $e * 0.000598 * sin(2.0 * ($me1 - $mf) - $ms);
    $l = $l + 0.00055 * sin($md + 4.0 * $me1) + 0.000538 * sin(4.0 * $md);
    $l = $l + $e * 0.000521 * sin(4.0 * $me1 - $ms) + 0.000486 * sin(2.0 * $md - $me1);
    $l = $l + $e2 * 0.000717 * sin($md - 2.0 * $ms);
    $mm = unwind($ml + deg2rad($l));

    return degrees($mm);
}

/**
 * Calculate geocentric ecliptic latitude for the Moon
 *
 * Original macro name: MoonLat
 */
function moon_lat($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr)
{
    $ut = local_civil_time_to_universal_time($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gd = local_civil_time_greenwich_day($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gm = local_civil_time_greenwich_month($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gy = local_civil_time_greenwich_year($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $t = ((civil_date_to_julian_date($gd, $gm, $gy) - 2415020) / 36525) + ($ut / 876600);
    $t2 = $t * $t;

    $m1 = 27.32158213;
    $m2 = 365.2596407;
    $m3 = 27.55455094;
    $m4 = 29.53058868;
    $m5 = 27.21222039;
    $m6 = 6798.363307;
    $q = civil_date_to_julian_date($gd, $gm, $gy) - 2415020 + ($ut / 24);
    $m1 = $q / $m1;
    $m2 = $q / $m2;
    $m3 = $q / $m3;
    $m4 = $q / $m4;
    $m5 = $q / $m5;
    $m6 = $q / $m6;
    $m1 = 360 * ($m1 - floor($m1));
    $m2 = 360 * ($m2 - floor($m2));
    $m3 = 360 * ($m3 - floor($m3));
    $m4 = 360 * ($m4 - floor($m4));
    $m5 = 360 * ($m5 - floor($m5));
    $m6 = 360 * ($m6 - floor($m6));

    $ml = 270.434164 + $m1 - (0.001133 - 0.0000019 * $t) * $t2;
    $ms = 358.475833 + $m2 - (0.00015 + 0.0000033 * $t) * $t2;
    $md = 296.104608 + $m3 + (0.009192 + 0.0000144 * $t) * $t2;
    $me1 = 350.737486 + $m4 - (0.001436 - 0.0000019 * $t) * $t2;
    $mf = 11.250889 + $m5 - (0.003211 + 0.0000003 * $t) * $t2;
    $na = 259.183275 - $m6 + (0.002078 + 0.0000022 * $t) * $t2;
    $a = deg2rad(51.2 + 20.2 * $t);
    $s1 = sin($a);
    $s2 = sin(deg2rad($na));
    $b = 346.56 + (132.87 - 0.0091731 * $t) * $t;
    $s3 = 0.003964 * sin(deg2rad($b));
    $c = deg2rad($na + 275.05 - 2.3 * $t);
    $s4 = sin($c);
    $ml = $ml + 0.000233 * $s1 + $s3 + 0.001964 * $s2;
    $ms = $ms - 0.001778 * $s1;
    $md = $md + 0.000817 * $s1 + $s3 + 0.002541 * $s2;
    $mf = $mf + $s3 - 0.024691 * $s2 - 0.004328 * $s4;
    $me1 = $me1 + 0.002011 * $s1 + $s3 + 0.001964 * $s2;
    $e = 1.0 - (0.002495 + 0.00000752 * $t) * $t;
    $e2 = $e * $e;
    $ms = deg2rad($ms);
    $na = deg2rad($na);
    $me1 = deg2rad($me1);
    $mf = deg2rad($mf);
    $md = deg2rad($md);

    $g = 5.128189 * sin($mf) + 0.280606 * sin($md + $mf);
    $g = $g + 0.277693 * sin($md - $mf) + 0.173238 * sin(2.0 * $me1 - $mf);
    $g = $g + 0.055413 * sin(2.0 * $me1 + $mf - $md) + 0.046272 * sin(2.0 * $me1 - $mf - $md);
    $g = $g + 0.032573 * sin(2.0 * $me1 + $mf) + 0.017198 * sin(2.0 * $md + $mf);
    $g = $g + 0.009267 * sin(2.0 * $me1 + $md - $mf) + 0.008823 * sin(2.0 * $md - $mf);
    $g = $g + $e * 0.008247 * sin(2.0 * $me1 - $ms - $mf) + 0.004323 * sin(2.0 * ($me1 - $md) - $mf);
    $g = $g + 0.0042 * sin(2.0 * $me1 + $mf + $md) + $e * 0.003372 * sin($mf - $ms - 2.0 * $me1);
    $g = $g + $e * 0.002472 * sin(2.0 * $me1 + $mf - $ms - $md);
    $g = $g + $e * 0.002222 * sin(2.0 * $me1 + $mf - $ms);
    $g = $g + $e * 0.002072 * sin(2.0 * $me1 - $mf - $ms - $md);
    $g = $g + $e * 0.001877 * sin($mf - $ms + $md) + 0.001828 * sin(4.0 * $me1 - $mf - $md);
    $g = $g - $e * 0.001803 * sin($mf + $ms) - 0.00175 * sin(3.0 * $mf);
    $g = $g + $e * 0.00157 * sin($md - $ms - $mf) - 0.001487 * sin($mf + $me1);
    $g = $g - $e * 0.001481 * sin($mf + $ms + $md) + $e * 0.001417 * sin($mf - $ms - $md);
    $g = $g + $e * 0.00135 * sin($mf - $ms) + 0.00133 * sin($mf - $me1);
    $g = $g + 0.001106 * sin($mf + 3.0 * $md) + 0.00102 * sin(4.0 * $me1 - $mf);
    $g = $g + 0.000833 * sin($mf + 4.0 * $me1 - $md) + 0.000781 * sin($md - 3.0 * $mf);
    $g = $g + 0.00067 * sin($mf + 4.0 * $me1 - 2.0 * $md) + 0.000606 * sin(2.0 * $me1 - 3.0 * $mf);
    $g = $g + 0.000597 * sin(2.0 * ($me1 + $md) - $mf);
    $g = $g + $e * 0.000492 * sin(2.0 * $me1 + $md - $ms - $mf) + 0.00045 * sin(2.0 * ($md - $me1) - $mf);
    $g = $g + 0.000439 * sin(3.0 * $md - $mf) + 0.000423 * sin($mf + 2.0 * ($me1 + $md));
    $g = $g + 0.000422 * sin(2.0 * $me1 - $mf - 3.0 * $md) - $e * 0.000367 * sin($ms + $mf + 2.0 * $me1 - $md);
    $g = $g - $e * 0.000353 * sin($ms + $mf + 2.0 * $me1) + 0.000331 * sin($mf + 4.0 * $me1);
    $g = $g + $e * 0.000317 * sin(2.0 * $me1 + $mf - $ms + $md);
    $g = $g + $e2 * 0.000306 * sin(2.0 * ($me1 - $ms) - $mf) - 0.000283 * sin($md + 3.0 * $mf);
    $w1 = 0.0004664 * cos($na);
    $w2 = 0.0000754 * cos($c);
    $bm = deg2rad($g) * (1.0 - $w1 - $w2);

    return degrees($bm);
}

/**
 * Calculate horizontal parallax for the Moon
 *
 * Original macro name: MoonHP
 */
function moon_hp($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr)
{
    $ut = local_civil_time_to_universal_time($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gd = local_civil_time_greenwich_day($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gm = local_civil_time_greenwich_month($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gy = local_civil_time_greenwich_year($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $t = ((civil_date_to_julian_date($gd, $gm, $gy) - 2415020) / 36525) + ($ut / 876600);
    $t2 = $t * $t;

    $m1 = 27.32158213;
    $m2 = 365.2596407;
    $m3 = 27.55455094;
    $m4 = 29.53058868;
    $m5 = 27.21222039;
    $m6 = 6798.363307;
    $q = civil_date_to_julian_date($gd, $gm, $gy) - 2415020 + ($ut / 24);
    $m1 = $q / $m1;
    $m2 = $q / $m2;
    $m3 = $q / $m3;
    $m4 = $q / $m4;
    $m5 = $q / $m5;
    $m6 = $q / $m6;
    $m1 = 360 * ($m1 - floor($m1));
    $m2 = 360 * ($m2 - floor($m2));
    $m3 = 360 * ($m3 - floor($m3));
    $m4 = 360 * ($m4 - floor($m4));
    $m5 = 360 * ($m5 - floor($m5));
    $m6 = 360 * ($m6 - floor($m6));

    $ml = 270.434164 + $m1 - (0.001133 - 0.0000019 * $t) * $t2;
    $ms = 358.475833 + $m2 - (0.00015 + 0.0000033 * $t) * $t2;
    $md = 296.104608 + $m3 + (0.009192 + 0.0000144 * $t) * $t2;
    $me1 = 350.737486 + $m4 - (0.001436 - 0.0000019 * $t) * $t2;
    $mf = 11.250889 + $m5 - (0.003211 + 0.0000003 * $t) * $t2;
    $na = 259.183275 - $m6 + (0.002078 + 0.0000022 * $t) * $t2;
    $a = deg2rad(51.2 + 20.2 * $t);
    $s1 = sin($a);
    $s2 = sin(deg2rad($na));
    $b = 346.56 + (132.87 - 0.0091731 * $t) * $t;
    $s3 = 0.003964 * sin(deg2rad($b));
    $c = deg2rad($na + 275.05 - 2.3 * $t);
    $s4 = sin($c);
    $ml = $ml + 0.000233 * $s1 + $s3 + 0.001964 * $s2;
    $ms = $ms - 0.001778 * $s1;
    $md = $md + 0.000817 * $s1 + $s3 + 0.002541 * $s2;
    $mf = $mf + $s3 - 0.024691 * $s2 - 0.004328 * $s4;
    $me1 = $me1 + 0.002011 * $s1 + $s3 + 0.001964 * $s2;
    $e = 1.0 - (0.002495 + 0.00000752 * $t) * $t;
    $e2 = $e * $e;
    $ms = deg2rad($ms);
    $me1 = deg2rad($me1);
    $mf = deg2rad($mf);
    $md = deg2rad($md);

    $pm = 0.950724 + 0.051818 * cos($md) + 0.009531 * cos(2.0 * $me1 - $md);
    $pm = $pm + 0.007843 * cos(2.0 * $me1) + 0.002824 * cos(2.0 * $md);
    $pm = $pm + 0.000857 * cos(2.0 * $me1 + $md) + $e * 0.000533 * cos(2.0 * $me1 - $ms);
    $pm = $pm + $e * 0.000401 * cos(2.0 * $me1 - $md - $ms);
    $pm = $pm + $e * 0.00032 * cos($md - $ms) - 0.000271 * cos($me1);
    $pm = $pm - $e * 0.000264 * cos($ms + $md) - 0.000198 * cos(2.0 * $mf - $md);
    $pm = $pm + 0.000173 * cos(3.0 * $md) + 0.000167 * cos(4.0 * $me1 - $md);
    $pm = $pm - $e * 0.000111 * cos($ms) + 0.000103 * cos(4.0 * $me1 - 2.0 * $md);
    $pm = $pm - 0.000084 * cos(2.0 * $md - 2.0 * $me1) - $e * 0.000083 * cos(2.0 * $me1 + $ms);
    $pm = $pm + 0.000079 * cos(2.0 * $me1 + 2.0 * $md) + 0.000072 * cos(4.0 * $me1);
    $pm = $pm + $e * 0.000064 * cos(2.0 * $me1 - $ms + $md) - $e * 0.000063 * cos(2.0 * $me1 + $ms - $md);
    $pm = $pm + $e * 0.000041 * cos($ms + $me1) + $e * 0.000035 * cos(2.0 * $md - $ms);
    $pm = $pm - 0.000033 * cos(3.0 * $md - 2.0 * $me1) - 0.00003 * cos($md + $me1);
    $pm = $pm - 0.000029 * cos(2.0 * ($mf - $me1)) - $e * 0.000029 * cos(2.0 * $md + $ms);
    $pm = $pm + $e2 * 0.000026 * cos(2.0 * ($me1 - $ms)) - 0.000023 * cos(2.0 * ($mf - $me1) + $md);
    $pm = $pm + $e * 0.000019 * cos(4.0 * $me1 - $ms - $md);

    return $pm;
}

/**
 * Calculate distance from the Earth to the Moon (km)
 *
 * Original macro name: MoonDist
 */
function moon_dist($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr)
{
    $hp = deg2rad(moon_hp($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr));
    $r = 6378.14 / sin($hp);

    return $r;
}

/**
 * Calculate the Moon's angular diameter (degrees)
 * 
 * Original macro name: MoonSize
 */
function moon_size($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr)
{
    $hp = deg2rad(moon_hp($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr));
    $r = 6378.14 / sin($hp);
    $th = 384401.0 * 0.5181 / $r;

    return $th;
}

/**
 * Convert angle in radians to equivalent angle in degrees.
 * 
 * Original macro name: Unwind
 */
function unwind($w)
{
    return $w - 6.283185308 * floor($w / 6.283185308);
}

/**
 * Convert angle in degrees to equivalent angle in the range 0 to 360 degrees.
 * 
 * Original macro name: UnwindDeg
 */
function unwind_deg($w)
{
    return $w - 360 * floor($w / 360);
}

/**
 * Mean ecliptic longitude of the Sun at the epoch
 * 
 * Original macro name: SunElong
 */
function sun_e_long($gd, $gm, $gy)
{
    $t = (civil_date_to_julian_date($gd, $gm, $gy) - 2415020) / 36525;
    $t2 = $t * $t;
    $x = 279.6966778 + 36000.76892 * $t + 0.0003025 * $t2;

    return $x - 360 * floor($x / 360);
}

/**
 * Longitude of the Sun at perigee
 * 
 * Original macro name: SunPeri
 */
function sun_peri($gd, $gm, $gy)
{
    $t = (civil_date_to_julian_date($gd, $gm, $gy) - 2415020) / 36525;
    $t2 = $t * $t;
    $x = 281.2208444 + 1.719175 * $t + 0.000452778 * $t2;

    return $x - 360 * floor($x / 360);
}

/**
 * Eccentricity of the Sun-Earth orbit
 * 
 * Original macro name: SunEcc
 */
function sun_ecc($gd, $gm, $gy)
{
    $t = (civil_date_to_julian_date($gd, $gm, $gy) - 2415020) / 36525;
    $t2 = $t * $t;

    return 0.01675104 - 0.0000418 * $t - 0.000000126 * $t2;
}

/**
 * Ecliptic - Declination (degrees)
 *
 * Original macro name: ECDec
 */
function ec_dec($eld, $elm, $els, $bd, $bm, $bs, $gd, $gm, $gy)
{
    $a =  deg2rad(degrees_minutes_seconds_to_decimal_degrees($eld, $elm, $els));
    $b = deg2rad(degrees_minutes_seconds_to_decimal_degrees($bd, $bm, $bs));
    $c = deg2rad(obliq($gd, $gm, $gy));
    $d = sin($b) * cos($c) + cos($b) * sin($c) * sin($a);

    return degrees(asin($d));
}

/**
 * Ecliptic - Right Ascension (degrees)
 * 
 * Original macro name: ECRA
 */
function ec_ra($eld, $elm, $els, $bd, $bm, $bs, $gd, $gm, $gy)
{
    $a = deg2rad(degrees_minutes_seconds_to_decimal_degrees($eld, $elm, $els));
    $b = deg2rad(degrees_minutes_seconds_to_decimal_degrees($bd, $bm, $bs));
    $c = deg2rad(obliq($gd, $gm, $gy));
    $d = sin($a) * cos($c) - tan($b) * sin($c);
    $e = cos($a);
    $f = degrees(atan2($d, $e));

    return $f - 360 * floor($f / 360);
}

/**
 * Calculate Sun's true anomaly, i.e., how much its orbit deviates from a true circle to an ellipse.
 * 
 * Original macro name: SunTrueAnomaly
 */
function sun_true_anomaly($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly)
{
    $aa = local_civil_time_greenwich_day($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly);
    $bb = local_civil_time_greenwich_month($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly);
    $cc = local_civil_time_greenwich_year($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly);
    $ut = local_civil_time_to_universal_time($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly);
    $dj = civil_date_to_julian_date($aa, $bb, $cc) - 2415020;

    $t = ($dj / 36525) + ($ut / 876600);
    $t2 = $t * $t;

    $a = 99.99736042 * $t;
    $b = 360 * ($a - floor($a));

    $m1 = 358.47583 - (0.00015 + 0.0000033 * $t) * $t2 + $b;
    $ec = 0.01675104 - 0.0000418 * $t - 0.000000126 * $t2;

    $am = deg2rad($m1);

    return degrees(true_anomaly($am, $ec));
}

/**
 * Calculate the Sun's mean anomaly.
 * 
 * Original macro name: SunMeanAnomaly
 */
function sun_mean_anomaly($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly)
{
    $aa = local_civil_time_greenwich_day($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly);
    $bb = local_civil_time_greenwich_month($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly);
    $cc = local_civil_time_greenwich_year($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly);
    $ut = local_civil_time_to_universal_time($lch, $lcm, $lcs, $ds, $zc, $ld, $lm, $ly);
    $dj = civil_date_to_julian_date($aa, $bb, $cc) - 2415020;
    $t = ($dj / 36525) + ($ut / 876600);
    $t2 = $t * $t;
    $a = 100.0021359 * $t;
    $b = 360 * ($a - floor($a));
    $m1 = 358.47583 - (0.00015 + 0.0000033 * $t) * $t2 + $b;
    $am = unwind(deg2rad($m1));

    return $am;
}

/**
 * Calculate local civil time of sunrise.
 *
 * Original macro name: SunriseLCT
 */
function sunrise_lct($ld, $lm, $ly, $ds, $zc, $gl, $gp)
{
    $di = 0.8333333;
    $gd = local_civil_time_greenwich_day(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $gm = local_civil_time_greenwich_month(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $gy = local_civil_time_greenwich_year(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $sr = sun_long(12, 0, 0, $ds, $zc, $ld, $lm, $ly);

    list($a, $x, $y, $la, $s) = sunrise_lct_3710($gd, $gm, $gy, $sr, $di, $gp);

    $xx = 0.0;
    if ($s != RiseSetStatus::OK) {
        $xx = -99.0;
    } else {
        $x = local_sidereal_time_to_greenwich_sidereal_time($la, 0, 0, $gl);
        $ut = greenwich_sidereal_time_to_universal_time($x, 0, 0, $gd, $gm, $gy);


        if (eg_st_ut($x, 0, 0, $gd, $gm, $gy) != WarningFlag::OK) {
            $xx = -99.0;
        } else {
            $sr = sun_long($ut, 0, 0, 0, 0, $gd, $gm, $gy);
            list($a, $x, $y, $la, $s) = sunrise_lct_3710($gd, $gm, $gy, $sr, $di, $gp);

            if ($s != RiseSetStatus::OK) {
                $xx = -99.0;
            } else {
                $x = local_sidereal_time_to_greenwich_sidereal_time($la, 0, 0, $gl);
                $ut = greenwich_sidereal_time_to_universal_time($x, 0, 0, $gd, $gm, $gy);
                $xx = universal_time_to_local_civil_time($ut, 0, 0, $ds, $zc, $gd, $gm, $gy);
            }
        }
    }

    return $xx;
}

/**
 * Helper function for sunrise_lct()
 */
function sunrise_lct_3710($gd, $gm, $gy, $sr, $di, $gp)
{
    $a = $sr + nutat_long($gd, $gm, $gy) - 0.005694;
    $x = ec_ra($a, 0, 0, 0, 0, 0, $gd, $gm, $gy);
    $y = ec_dec($a, 0, 0, 0, 0, 0, $gd, $gm, $gy);
    $la = rise_set_local_sidereal_time_rise(decimal_degrees_to_degree_hours($x), 0, 0, $y, 0, 0, $di, $gp);
    $s = ers(decimal_degrees_to_degree_hours($x), 0.0, 0.0, $y, 0.0, 0.0, $di, $gp);

    return array($a, $x, $y, $la, $s);
}

/**
 * Calculate local civil time of sunset.
 * 
 * Original macro name: SunsetLCT
 */
function sunset_lct($ld, $lm, $ly, $ds, $zc, $gl, $gp)
{
    $di = 0.8333333;
    $gd = local_civil_time_greenwich_day(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $gm = local_civil_time_greenwich_month(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $gy = local_civil_time_greenwich_year(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $sr = sun_long(12, 0, 0, $ds, $zc, $ld, $lm, $ly);

    list($a, $x, $y, $la, $s) = sunset_lct_l3710($gd, $gm, $gy, $sr, $di, $gp);

    $xx = 0.0;
    if ($s != RiseSetStatus::OK) {
        $xx = -99.0;
    } else {
        $x = local_sidereal_time_to_greenwich_sidereal_time($la, 0, 0, $gl);
        $ut = greenwich_sidereal_time_to_universal_time($x, 0, 0, $gd, $gm, $gy);

        if (eg_st_ut($x, 0, 0, $gd, $gm, $gy) != WarningFlag::OK) {
            $xx = -99.0;
        } else {
            $sr = sun_long($ut, 0, 0, 0, 0, $gd, $gm, $gy);
            list($a, $x, $y, $la, $s) = sunset_lct_l3710($gd, $gm, $gy, $sr, $di, $gp);

            if ($s != RiseSetStatus::OK) {
                $xx = -99;
            } else {
                $x = local_sidereal_time_to_greenwich_sidereal_time($la, 0, 0, $gl);
                $ut = greenwich_sidereal_time_to_universal_time($x, 0, 0, $gd, $gm, $gy);
                $xx = universal_time_to_local_civil_time($ut, 0, 0, $ds, $zc, $gd, $gm, $gy);
            }
        }
    }
    return $xx;
}

/**
 * Helper function for sunset_lct().
 */
function sunset_lct_l3710($gd, $gm, $gy, $sr, $di, $gp)
{
    $a = $sr + nutat_long($gd, $gm, $gy) - 0.005694;
    $x = ec_ra($a, 0.0, 0.0, 0.0, 0.0, 0.0, $gd, $gm, $gy);
    $y = ec_dec($a, 0.0, 0.0, 0.0, 0.0, 0.0, $gd, $gm, $gy);
    $la = rise_set_local_sidereal_time_set(decimal_degrees_to_degree_hours($x), 0, 0, $y, 0, 0, $di, $gp);
    $s = ers(decimal_degrees_to_degree_hours($x), 0, 0, $y, 0, 0, $di, $gp);

    return array($a, $x, $y, $la, $s);
}

/**
 * Local sidereal time of rise, in hours.
 * 
 * Original macro name: RSLSTR
 */
function rise_set_local_sidereal_time_rise($rah, $ram, $ras, $dd, $dm, $ds, $vd, $g)
{
    $a = hours_minutes_seconds_to_decimal_hours($rah, $ram, $ras);
    $b = deg2rad(degree_hours_to_decimal_degrees($a));
    $c = deg2rad(degrees_minutes_seconds_to_decimal_degrees($dd, $dm, $ds));
    $d = deg2rad($vd);
    $e = deg2rad($g);
    $f = - (sin($d) + sin($e) * sin($c)) / (cos($e) * cos($c));
    $h = (abs($f) < 1) ? acos($f) : 0;
    $i = decimal_degrees_to_degree_hours(degrees($b - $h));

    return $i - 24 * floor($i / 24);
}

/**
 * Local sidereal time of setting, in hours.
 * 
 * Original macro name: RSLSTS
 */
function  rise_set_local_sidereal_time_set($rah, $ram, $ras, $dd, $dm, $ds, $vd, $g)
{
    $a = hours_minutes_seconds_to_decimal_hours($rah, $ram, $ras);
    $b = deg2rad(degree_hours_to_decimal_degrees($a));
    $c = deg2rad(degrees_minutes_seconds_to_decimal_degrees($dd, $dm, $ds));
    $d = deg2rad($vd);
    $e = deg2rad($g);
    $f = - (sin($d) + sin($e) * sin($c)) / (cos($e) * cos($c));
    $h = (abs($f) < 1) ? acos($f) : 0;
    $i = decimal_degrees_to_degree_hours(degrees($b + $h));

    return $i - 24 * floor($i / 24);
}

/**
 * Azimuth of rising, in degrees.
 * 
 * Original macro name: RSAZR
 */
function rise_set_azimuth_rise($rah, $ram, $ras, $dd, $dm, $ds, $vd, $g)
{
    $a = hours_minutes_seconds_to_decimal_hours($rah, $ram, $ras);
    $c = deg2rad(degrees_minutes_seconds_to_decimal_degrees($dd, $dm, $ds));
    $d = deg2rad($vd);
    $e = deg2rad($g);
    $f = (sin($c) + sin($d) * sin($e)) / (cos($d) * cos($e));
    $h = ers($rah, $ram, $ras, $dd, $dm, $ds, $vd, $g) == RiseSetStatus::OK ? acos($f) : 0;
    $i = degrees($h);

    return $i - 360 * floor($i / 360);
}

/**
 * Azimuth of setting, in degrees.
 * 
 * Original macro name: RSAZS
 */
function rise_set_azimuth_set($rah, $ram, $ras, $dd, $dm, $ds, $vd, $g)
{
    $a = hours_minutes_seconds_to_decimal_hours($rah, $ram, $ras);
    $c = deg2rad(degrees_minutes_seconds_to_decimal_degrees($dd, $dm, $ds));
    $d = deg2rad($vd);
    $e = deg2rad($g);
    $f = (sin($c) + sin($d) * sin($e)) / (cos($d) * cos($e));
    $h = ers($rah, $ram, $ras, $dd, $dm, $ds, $vd, $g) == RiseSetStatus::OK ? acos($f) : 0;
    $i = 360 - degrees($h);

    return $i - 360 * floor($i / 360);
}

/**
 * Rise/Set status
 * 
 * Original macro name: eRS
 */
function ers($rah, $ram, $ras, $dd, $dm, $ds, $vd, $g)
{
    $a = hours_minutes_seconds_to_decimal_hours($rah, $ram, $ras);
    $c = deg2rad(degrees_minutes_seconds_to_decimal_degrees($dd, $dm, $ds));
    $d = deg2rad($vd);
    $e = deg2rad($g);
    $f = - (sin($d) + sin($e) * sin($c)) / (cos($e)  * cos($c));

    $returnValue = RiseSetStatus::OK;
    if ($f >= 1)
        $returnValue = RiseSetStatus::NeverRises;
    if ($f <= -1)
        $returnValue = RiseSetStatus::Circumpolar;

    return $returnValue;
}

/**
 * Sunrise/Sunset calculation status.
 * 
 * Original macro name: eSunRS
 */
function e_sun_rs($ld, $lm, $ly, $ds, $zc, $gl, $gp)
{
    $di = 0.8333333;
    $gd = local_civil_time_greenwich_day(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $gm = local_civil_time_greenwich_month(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $gy = local_civil_time_greenwich_year(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $sr = sun_long(12, 0, 0, $ds, $zc, $ld, $lm, $ly);

    list($a, $x, $y, $la, $s) = e_sun_rs_l3710($gd, $gm, $gy, $sr, $di, $gp);

    if ($s != RiseSetStatus::OK) {
        return $s;
    } else {
        $x = local_sidereal_time_to_greenwich_sidereal_time($la, 0, 0, $gl);
        $ut = greenwich_sidereal_time_to_universal_time($x, 0, 0, $gd, $gm, $gy);
        $sr = sun_long($ut, 0, 0, 0, 0, $gd, $gm, $gy);
        list($a, $x, $y, $la, $s) = e_sun_rs_l3710($gd, $gm, $gy, $sr, $di, $gp);
        if ($s != RiseSetStatus::OK) {
            return $s;
        } else {
            $x = local_sidereal_time_to_greenwich_sidereal_time($la, 0, 0, $gl);

            if (eg_st_ut($x, 0, 0, $gd, $gm, $gy)   != WarningFlag::OK) {
                $s = RiseSetStatus::GstToUtConversionWarning;

                return $s;
            }

            return $s;
        }
    }
}

/**
 * Helper function for e_sun_rs
 */
function e_sun_rs_l3710($gd, $gm, $gy, $sr, $di, $gp)
{
    $a = $sr + nutat_long($gd, $gm, $gy) - 0.005694;
    $x = ec_ra($a, 0, 0, 0, 0, 0, $gd, $gm, $gy);
    $y = ec_dec($a, 0, 0, 0, 0, 0, $gd, $gm, $gy);
    $la = rise_set_local_sidereal_time_rise(decimal_degrees_to_degree_hours($x), 0, 0, $y, 0, 0, $di, $gp);
    $s = ers(decimal_degrees_to_degree_hours($x), 0, 0, $y, 0, 0, $di, $gp);

    return array($a, $x, $y, $la, $s);
}

/**
 * Calculate azimuth of sunrise.
 * 
 * Original macro name: SunriseAz
 */
function sunrise_az($ld, $lm, $ly, $ds, $zc, $gl, $gp)
{
    $di = 0.8333333;
    $gd = local_civil_time_greenwich_day(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $gm = local_civil_time_greenwich_month(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $gy = local_civil_time_greenwich_year(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $sr = sun_long(12, 0, 0, $ds, $zc, $ld, $lm, $ly);

    list($result1_a, $result1_x, $result1_y, $result1_la, $result1_s) = sunrise_az_l3710($gd, $gm, $gy, $sr, $di, $gp);

    if ($result1_s != RiseSetStatus::OK) {
        return -99.0;
    }

    $x = local_sidereal_time_to_greenwich_sidereal_time($result1_la, 0, 0, $gl);
    $ut = greenwich_sidereal_time_to_universal_time($x, 0, 0, $gd, $gm, $gy);

    if (eg_st_ut($x, 0, 0, $gd, $gm, $gy) != WarningFlag::OK) {
        return -99.0;
    }

    $sr = sun_long($ut, 0, 0, 0, 0, $gd, $gm, $gy);
    list($result2_a, $result2_x, $result2_y, $result2_la, $result2_s) = sunrise_az_l3710($gd, $gm, $gy, $sr, $di, $gp);

    if ($result2_s != RiseSetStatus::OK) {
        return -99.0;
    }

    return rise_set_azimuth_rise(decimal_degrees_to_degree_hours($x), 0, 0, $result2_y, 0.0, 0.0, $di, $gp);
}

/**
 * Helper function for sunrise_az()
 */
function sunrise_az_l3710($gd, $gm, $gy, $sr, $di, $gp)
{
    $a = $sr + nutat_long($gd, $gm, $gy) - 0.005694;
    $x = ec_ra($a, 0, 0, 0, 0, 0, $gd, $gm, $gy);
    $y = ec_dec($a, 0, 0, 0, 0, 0, $gd, $gm, $gy);
    $la = rise_set_local_sidereal_time_rise(decimal_degrees_to_degree_hours($x), 0, 0, $y, 0, 0, $di, $gp);
    $s = ers(decimal_degrees_to_degree_hours($x), 0, 0, $y, 0, 0, $di, $gp);

    return array($a, $x, $y, $la, $s);
}

/**
 * Calculate azimuth of sunset.
 * 
 * Original macro name: SunsetAz
 */
function sunset_az($ld, $lm, $ly, $ds, $zc, $gl, $gp)
{
    $di = 0.8333333;
    $gd = local_civil_time_greenwich_day(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $gm = local_civil_time_greenwich_month(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $gy = local_civil_time_greenwich_year(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $sr = sun_long(12, 0, 0, $ds, $zc, $ld, $lm, $ly);

    list($result1_a, $result1_x, $result1_y, $result1_la, $result1_s) = sunset_az_l3710($gd, $gm, $gy, $sr, $di, $gp);

    if ($result1_s != RiseSetStatus::OK) {
        return -99.0;
    }

    $x = local_sidereal_time_to_greenwich_sidereal_time($result1_la, 0, 0, $gl);
    $ut = greenwich_sidereal_time_to_universal_time($x, 0, 0, $gd, $gm, $gy);

    if (eg_st_ut($x, 0, 0, $gd, $gm, $gy) != WarningFlag::OK) {
        return -99.0;
    }

    $sr = sun_long($ut, 0, 0, 0, 0, $gd, $gm, $gy);

    list($result2_a, $result2_x, $result2_y, $result2_la, $result2_s) = sunset_az_l3710($gd, $gm, $gy, $sr, $di, $gp);

    if ($result2_s != RiseSetStatus::OK) {
        return -99.0;
    }

    return rise_set_azimuth_set(decimal_degrees_to_degree_hours($x), 0, 0, $result2_y, 0, 0, $di, $gp);
}

/**
 * Helper function for sunset_az()
 */
function sunset_az_l3710($gd, $gm, $gy, $sr, $di, $gp)
{
    $a = $sr + nutat_long($gd, $gm, $gy) - 0.005694;
    $x = ec_ra($a, 0, 0, 0, 0, 0, $gd, $gm, $gy);
    $y = ec_dec($a, 0, 0, 0, 0, 0, $gd, $gm, $gy);
    $la = rise_set_local_sidereal_time_set(decimal_degrees_to_degree_hours($x), 0, 0, $y, 0, 0, $di, $gp);
    $s = ers(decimal_degrees_to_degree_hours($x), 0, 0, $y, 0, 0, $di, $gp);

    return array($a, $x, $y, $la, $s);
}
