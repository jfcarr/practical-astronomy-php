<?php

namespace PA\Macros;

include_once 'PATypes.php';

use PA\Data\Planets\PlanetDataPrecise;
use PA\Types as PA_Types;
use PA\Types\AngleMeasure;
use PA\Types\RiseSetStatus;
use PA\Types\TwilightStatus;
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
 * Convert W to Degrees
 * 
 * Original macro name: Degrees
 */
function w_to_degrees($w)
{
    return $w * 57.29577951;
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

/**
 * Calculate morning twilight start, in local time.
 * 
 * Original macro name: TwilightAMLCT
 */
function twilight_am_lct($ld, $lm, $ly, $ds, $zc, $gl, $gp, $tt)
{
    $di = (float)$tt->value;

    $gd = local_civil_time_greenwich_day(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $gm = local_civil_time_greenwich_month(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $gy = local_civil_time_greenwich_year(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $sr = sun_long(12, 0, 0, $ds, $zc, $ld, $lm, $ly);

    list($result1_a, $result1_x, $result1_y, $result1_la, $result1_s) = twilight_am_lct_l3710($gd, $gm, $gy, $sr, $di, $gp);

    if ($result1_s != RiseSetStatus::OK)
        return -99.0;

    $x = local_sidereal_time_to_greenwich_sidereal_time($result1_la, 0, 0, $gl);
    $ut = greenwich_sidereal_time_to_universal_time($x, 0, 0, $gd, $gm, $gy);

    if (eg_st_ut($x, 0, 0, $gd, $gm, $gy) != WarningFlag::OK)
        return -99.0;

    $sr = sun_long($ut, 0, 0, 0, 0, $gd, $gm, $gy);

    list($result2_a, $result2_x, $result2_y, $result2_la, $result2_s) = twilight_am_lct_l3710($gd, $gm, $gy, $sr, $di, $gp);

    if ($result2_s != RiseSetStatus::OK)
        return -99.0;

    $x = local_sidereal_time_to_greenwich_sidereal_time($result2_la, 0, 0, $gl);
    $ut = greenwich_sidereal_time_to_universal_time($x, 0, 0, $gd, $gm, $gy);

    $xx = universal_time_to_local_civil_time($ut, 0, 0, $ds, $zc, $gd, $gm, $gy);

    return $xx;
}

/**
 * Helper function for twilight_am_lct()
 */
function twilight_am_lct_l3710($gd, $gm, $gy, $sr, $di, $gp)
{
    $a = $sr + nutat_long($gd, $gm, $gy) - 0.005694;
    $x = ec_ra($a, 0, 0, 0, 0, 0, $gd, $gm, $gy);
    $y = ec_dec($a, 0, 0, 0, 0, 0, $gd, $gm, $gy);
    $la = rise_set_local_sidereal_time_rise(decimal_degrees_to_degree_hours($x), 0, 0, $y, 0, 0, $di, $gp);
    $s = ers(decimal_degrees_to_degree_hours($x), 0, 0, $y, 0, 0, $di, $gp);

    return array($a, $x, $y, $la, $s);
}

/**
 * Calculate evening twilight end, in local time.
 * 
 * Original macro name: TwilightPMLCT
 */
function twilight_pm_lct($ld, $lm, $ly, $ds, $zc, $gl, $gp, $tt)
{
    $di = (float)$tt->value;

    $gd = local_civil_time_greenwich_day(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $gm = local_civil_time_greenwich_month(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $gy = local_civil_time_greenwich_year(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $sr = sun_long(12, 0, 0, $ds, $zc, $ld, $lm, $ly);

    list($result1_a, $result1_x, $result1_y, $result1_la, $result1_s) = twilight_pm_lct_l3710($gd, $gm, $gy, $sr, $di, $gp);

    if ($result1_s != RiseSetStatus::OK)
        return 0.0;

    $x = local_sidereal_time_to_greenwich_sidereal_time($result1_la, 0, 0, $gl);
    $ut = greenwich_sidereal_time_to_universal_time($x, 0, 0, $gd, $gm, $gy);

    if (eg_st_ut($x, 0, 0, $gd, $gm, $gy) != WarningFlag::OK)
        return 0.0;

    $sr = sun_long($ut, 0, 0, 0, 0, $gd, $gm, $gy);

    list($result2_a, $result2_x, $result2_y, $result2_la, $result2_s) = twilight_pm_lct_l3710($gd, $gm, $gy, $sr, $di, $gp);

    if ($result2_s != RiseSetStatus::OK)
        return 0.0;

    $x = local_sidereal_time_to_greenwich_sidereal_time($result2_la, 0, 0, $gl);
    $ut = greenwich_sidereal_time_to_universal_time($x, 0, 0, $gd, $gm, $gy);

    return universal_time_to_local_civil_time($ut, 0, 0, $ds, $zc, $gd, $gm, $gy);
}

/**
 * Helper function for twilight_pm_lct()
 */
function twilight_pm_lct_l3710($gd, $gm, $gy, $sr, $di, $gp)
{
    $a = $sr + nutat_long($gd, $gm, $gy) - 0.005694;
    $x = ec_ra($a, 0, 0, 0, 0, 0, $gd, $gm, $gy);
    $y = ec_dec($a, 0, 0, 0, 0, 0, $gd, $gm, $gy);
    $la = rise_set_local_sidereal_time_set(decimal_degrees_to_degree_hours($x), 0, 0, $y, 0, 0, $di, $gp);
    $s = ers(decimal_degrees_to_degree_hours($x), 0, 0, $y, 0, 0, $di, $gp);

    return array($a, $x, $y, $la, $s);
}

/**
 * Twilight calculation status.
 * 
 * Original macro name: eTwilight
 */
function e_twilight($ld, $lm, $ly, $ds, $zc, $gl, $gp, $tt)
{
    $di = (float)$tt->value;

    $gd = local_civil_time_greenwich_day(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $gm = local_civil_time_greenwich_month(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $gy = local_civil_time_greenwich_year(12, 0, 0, $ds, $zc, $ld, $lm, $ly);
    $sr = sun_long(12, 0, 0, $ds, $zc, $ld, $lm, $ly);

    list($result1_a, $result1_x, $result1_y, $result1_la, $result1_s) = e_twilight_l3710($gd, $gm, $gy, $sr, $di, $gp);

    if ($result1_s != TwilightStatus::OK)
        return $result1_s;

    $x = local_sidereal_time_to_greenwich_sidereal_time($result1_la, 0, 0, $gl);
    $ut = greenwich_sidereal_time_to_universal_time($x, 0, 0, $gd, $gm, $gy);
    $sr = sun_long($ut, 0, 0, 0, 0, $gd, $gm, $gy);

    list($result2_a, $result2_x, $result2_y, $result2_la, $result2_s) = e_twilight_l3710($gd, $gm, $gy, $sr, $di, $gp);

    if ($result2_s != TwilightStatus::OK)
        return $result2_s;

    $x = local_sidereal_time_to_greenwich_sidereal_time($result2_la, 0, 0, $gl);

    if (eg_st_ut($x, 0, 0, $gd, $gm, $gy) != WarningFlag::OK) {
        $result2_s = TwilightStatus::GstToUtConversionWarning;

        return $result2_s;
    }

    return $result2_s;
}

/**
 * Helper function for e_twilight()
 */
function e_twilight_l3710($gd, $gm, $gy, $sr, $di, $gp)
{
    $a = $sr + nutat_long($gd, $gm, $gy) - 0.005694;
    $x = ec_ra($a, 0, 0, 0, 0, 0, $gd, $gm, $gy);
    $y = ec_dec($a, 0, 0, 0, 0, 0, $gd, $gm, $gy);
    $la = rise_set_local_sidereal_time_rise(decimal_degrees_to_degree_hours($x), 0, 0, $y, 0, 0, $di, $gp);
    $s = ers(decimal_degrees_to_degree_hours($x), 0, 0, $y, 0, 0, $di, $gp);

    $ts = TwilightStatus::OK;

    if ($s == RiseSetStatus::Circumpolar)
        $ts = TwilightStatus::LastsAllNight;

    if ($s == RiseSetStatus::NeverRises)
        $ts = TwilightStatus::SunTooFarBelowHorizon;

    return array($a, $x, $y, $la, $ts);
}

/**
 * Calculate the angle between two celestial objects
 */
function angle($xx1, $xm1, $xs1, $dd1, $dm1, $ds1, $xx2, $xm2, $xs2, $dd2, $dm2, $ds2, $s)
{
    $a = ($s == AngleMeasure::Hours)
        ? degree_hours_to_decimal_degrees(hours_minutes_seconds_to_decimal_hours($xx1, $xm1, $xs1))
        : degrees_minutes_seconds_to_decimal_degrees($xx1, $xm1, $xs1);
    $b = deg2rad($a);
    $c = degrees_minutes_seconds_to_decimal_degrees($dd1, $dm1, $ds1);
    $d = deg2rad($c);
    $e = ($s == AngleMeasure::Hours)
        ? degree_hours_to_decimal_degrees(hours_minutes_seconds_to_decimal_hours($xx2, $xm2, $xs2))
        : degrees_minutes_seconds_to_decimal_degrees($xx2, $xm2, $xs2);
    $f = deg2rad($e);
    $g = degrees_minutes_seconds_to_decimal_degrees($dd2, $dm2, $ds2);
    $h = deg2rad($g);
    $i = acos(sin($d) * sin($h) + cos($d) * cos($h) * cos($b - $f));

    return w_to_degrees($i);
}

/**
 * Calculate several planetary properties.
 *
 * Original macro names: PlanetLong, PlanetLat, PlanetDist, PlanetHLong1, PlanetHLong2, PlanetHLat, PlanetRVect
 */
function planet_coordinates($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr, $s)
{
    $a11 = 178.179078;
    $a12 = 415.2057519;
    $a13 = 0.0003011;
    $a14 = 0.0;
    $a21 = 75.899697;
    $a22 = 1.5554889;
    $a23 = 0.0002947;
    $a24 = 0.0;
    $a31 = 0.20561421;
    $a32 = 0.00002046;
    $a33 = -0.00000003;
    $a34 = 0.0;
    $a41 = 7.002881;
    $a42 = 0.0018608;
    $a43 = -0.0000183;
    $a44 = 0.0;
    $a51 = 47.145944;
    $a52 = 1.1852083;
    $a53 = 0.0001739;
    $a54 = 0.0;
    $a61 = 0.3870986;
    $a62 = 6.74;
    $a63 = -0.42;

    $b11 = 342.767053;
    $b12 = 162.5533664;
    $b13 = 0.0003097;
    $b14 = 0.0;
    $b21 = 130.163833;
    $b22 = 1.4080361;
    $b23 = -0.0009764;
    $b24 = 0.0;
    $b31 = 0.00682069;
    $b32 = -0.00004774;
    $b33 = 0.000000091;
    $b34 = 0.0;
    $b41 = 3.393631;
    $b42 = 0.0010058;
    $b43 = -0.000001;
    $b44 = 0.0;
    $b51 = 75.779647;
    $b52 = 0.89985;
    $b53 = 0.00041;
    $b54 = 0.0;
    $b61 = 0.7233316;
    $b62 = 16.92;
    $b63 = -4.4;

    $c11 = 293.737334;
    $c12 = 53.17137642;
    $c13 = 0.0003107;
    $c14 = 0.0;
    $c21 = 334.218203;
    $c22 = 1.8407584;
    $c23 = 0.0001299;
    $c24 = -0.00000119;
    $c31 = 0.0933129;
    $c32 = 0.000092064;
    $c33 = -0.000000077;
    $c34 = 0.0;
    $c41 = 1.850333;
    $c42 = -0.000675;
    $c43 = 0.0000126;
    $c44 = 0.0;
    $c51 = 48.786442;
    $c52 = 0.7709917;
    $c53 = -0.0000014;
    $c54 = -0.00000533;
    $c61 = 1.5236883;
    $c62 = 9.36;
    $c63 = -1.52;

    $d11 = 238.049257;
    $d12 = 8.434172183;
    $d13 = 0.0003347;
    $d14 = -0.00000165;
    $d21 = 12.720972;
    $d22 = 1.6099617;
    $d23 = 0.00105627;
    $d24 = -0.00000343;
    $d31 = 0.04833475;
    $d32 = 0.00016418;
    $d33 = -0.0000004676;
    $d34 = -0.0000000017;
    $d41 = 1.308736;
    $d42 = -0.0056961;
    $d43 = 0.0000039;
    $d44 = 0.0;
    $d51 = 99.443414;
    $d52 = 1.01053;
    $d53 = 0.00035222;
    $d54 = -0.00000851;
    $d61 = 5.202561;
    $d62 = 196.74;
    $d63 = -9.4;

    $e11 = 266.564377;
    $e12 = 3.398638567;
    $e13 = 0.0003245;
    $e14 = -0.0000058;
    $e21 = 91.098214;
    $e22 = 1.9584158;
    $e23 = 0.00082636;
    $e24 = 0.00000461;
    $e31 = 0.05589232;
    $e32 = -0.0003455;
    $e33 = -0.000000728;
    $e34 = 0.00000000074;
    $e41 = 2.492519;
    $e42 = -0.0039189;
    $e43 = -0.00001549;
    $e44 = 0.00000004;
    $e51 = 112.790414;
    $e52 = 0.8731951;
    $e53 = -0.00015218;
    $e54 = -0.00000531;
    $e61 = 9.554747;
    $e62 = 165.6;
    $e63 = -8.88;

    $f11 = 244.19747;
    $f12 = 1.194065406;
    $f13 = 0.000316;
    $f14 = -0.0000006;
    $f21 = 171.548692;
    $f22 = 1.4844328;
    $f23 = 0.0002372;
    $f24 = -0.00000061;
    $f31 = 0.0463444;
    $f32a = -0.00002658;
    $f33 = 0.000000077;
    $f34 = 0.0;
    $f41 = 0.772464;
    $f42 = 0.0006253;
    $f43 = 0.0000395;
    $f44 = 0.0;
    $f51 = 73.477111;
    $f52 = 0.4986678;
    $f53 = 0.0013117;
    $f54 = 0.0;
    $f61 = 19.21814;
    $f62 = 65.8;
    $f63 = -7.19;

    $g11 = 84.457994;
    $g12 = 0.6107942056;
    $g13 = 0.0003205;
    $g14 = -0.0000006;
    $g21 = 46.727364;
    $g22 = 1.4245744;
    $g23 = 0.00039082;
    $g24 = -0.000000605;
    $g31 = 0.00899704;
    $g32 = 0.00000633;
    $g33 = -0.000000002;
    $g34 = 0.0;
    $g41 = 1.779242;
    $g42 = -0.0095436;
    $g43 = -0.0000091;
    $g44 = 0.0;
    $g51 = 130.681389;
    $g52 = 1.098935;
    $g53 = 0.00024987;
    $g54 = -0.000004718;
    $g61 = 30.10957;
    $g62 = 62.2;
    $g63 = -6.87;

    $planet_data = [];

    $planet_data[] = new PlanetDataPrecise("", 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

    $ip = 0;
    $b = local_civil_time_to_universal_time($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gd = local_civil_time_greenwich_day($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gm = local_civil_time_greenwich_month($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gy = local_civil_time_greenwich_year($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $a = civil_date_to_julian_date($gd, $gm, $gy);
    $t = (($a - 2415020.0) / 36525.0) + ($b / 876600.0);

    $a0 = $a11;
    $a1 = $a12;
    $a2 = $a13;
    $a3 = $a14;
    $b0 = $a21;
    $b1 = $a22;
    $b2 = $a23;
    $b3 = $a24;
    $c0 = $a31;
    $c1 = $a32;
    $c2 = $a33;
    $c3 = $a34;
    $d0 = $a41;
    $d1 = $a42;
    $d2 = $a43;
    $d3 = $a44;
    $e0 = $a51;
    $e1 = $a52;
    $e2 = $a53;
    $e3 = $a54;
    $f = $a61;
    $g = $a62;
    $h = $a63;
    $aa = $a1 * $t;
    $b = 360.0 * ($aa - floor($aa));
    $c = $a0 + $b + ($a3 * $t + $a2) * $t * $t;

    $planet_data[] = new PlanetDataPrecise(
        "Mercury",
        $c - 360.0 * floor($c / 360.0),
        ($a1 * 0.009856263) + ($a2 + $a3) / 36525.0,
        (($b3 * $t + $b2) * $t + $b1) * $t + $b0,
        (($c3 * $t + $c2) * $t + $c1) * $t + $c0,
        (($d3 * $t + $d2) * $t + $d1) * $t + $d0,
        (($e3 * $t + $e2) * $t + $e1) * $t + $e0,
        $f,
        $g,
        $h,
        0
    );

    $a0 = $b11;
    $a1 = $b12;
    $a2 = $b13;
    $a3 = $b14;
    $b0 = $b21;
    $b1 = $b22;
    $b2 = $b23;
    $b3 = $b24;
    $c0 = $b31;
    $c1 = $b32;
    $c2 = $b33;
    $c3 = $b34;
    $d0 = $b41;
    $d1 = $b42;
    $d2 = $b43;
    $d3 = $b44;
    $e0 = $b51;
    $e1 = $b52;
    $e2 = $b53;
    $e3 = $b54;
    $f = $b61;
    $g = $b62;
    $h = $b63;
    $aa = $a1 * $t;
    $b = 360.0 * ($aa - floor($aa));
    $c = $a0 + $b + ($a3 * $t + $a2) * $t * $t;

    $planet_data[] = new PlanetDataPrecise(
        "Venus",
        $c - 360.0 * floor($c / 360.0),
        ($a1 * 0.009856263) + ($a2 + $a3) / 36525.0,
        (($b3 * $t + $b2) * $t + $b1) * $t + $b0,
        (($c3 * $t + $c2) * $t + $c1) * $t + $c0,
        (($d3 * $t + $d2) * $t + $d1) * $t + $d0,
        (($e3 * $t + $e2) * $t + $e1) * $t + $e0,
        $f,
        $g,
        $h,
        0
    );

    $a0 = $c11;
    $a1 = $c12;
    $a2 = $c13;
    $a3 = $c14;
    $b0 = $c21;
    $b1 = $c22;
    $b2 = $c23;
    $b3 = $c24;
    $c0 = $c31;
    $c1 = $c32;
    $c2 = $c33;
    $c3 = $c34;
    $d0 = $c41;
    $d1 = $c42;
    $d2 = $c43;
    $d3 = $c44;
    $e0 = $c51;
    $e1 = $c52;
    $e2 = $c53;
    $e3 = $c54;
    $f = $c61;
    $g = $c62;
    $h = $c63;

    $aa = $a1 * $t;
    $b = 360.0 * ($aa - floor($aa));
    $c = $a0 + $b + ($a3 * $t + $a2) * $t * $t;

    $planet_data[] = new PlanetDataPrecise(
        "Mars",
        $c - 360.0 * floor($c / 360.0),
        ($a1 * 0.009856263) + ($a2 + $a3) / 36525.0,
        (($b3 * $t + $b2) * $t + $b1) * $t + $b0,
        (($c3 * $t + $c2) * $t + $c1) * $t + $c0,
        (($d3 * $t + $d2) * $t + $d1) * $t + $d0,
        (($e3 * $t + $e2) * $t + $e1) * $t + $e0,
        $f,
        $g,
        $h,
        0
    );

    $a0 = $d11;
    $a1 = $d12;
    $a2 = $d13;
    $a3 = $d14;
    $b0 = $d21;
    $b1 = $d22;
    $b2 = $d23;
    $b3 = $d24;
    $c0 = $d31;
    $c1 = $d32;
    $c2 = $d33;
    $c3 = $d34;
    $d0 = $d41;
    $d1 = $d42;
    $d2 = $d43;
    $d3 = $d44;
    $e0 = $d51;
    $e1 = $d52;
    $e2 = $d53;
    $e3 = $d54;
    $f = $d61;
    $g = $d62;
    $h = $d63;

    $aa = $a1 * $t;
    $b = 360.0 * ($aa - floor($aa));
    $c = $a0 + $b + ($a3 * $t + $a2) * $t * $t;

    $planet_data[] = new PlanetDataPrecise(
        "Jupiter",
        $c - 360.0 * floor($c / 360.0),
        ($a1 * 0.009856263) + ($a2 + $a3) / 36525.0,
        (($b3 * $t + $b2) * $t + $b1) * $t + $b0,
        (($c3 * $t + $c2) * $t + $c1) * $t + $c0,
        (($d3 * $t + $d2) * $t + $d1) * $t + $d0,
        (($e3 * $t + $e2) * $t + $e1) * $t + $e0,
        $f,
        $g,
        $h,
        0
    );

    $a0 = $e11;
    $a1 = $e12;
    $a2 = $e13;
    $a3 = $e14;
    $b0 = $e21;
    $b1 = $e22;
    $b2 = $e23;
    $b3 = $e24;
    $c0 = $e31;
    $c1 = $e32;
    $c2 = $e33;
    $c3 = $e34;
    $d0 = $e41;
    $d1 = $e42;
    $d2 = $e43;
    $d3 = $e44;
    $e0 = $e51;
    $e1 = $e52;
    $e2 = $e53;
    $e3 = $e54;
    $f = $e61;
    $g = $e62;
    $h = $e63;

    $aa = $a1 * $t;
    $b = 360.0 * ($aa - floor($aa));
    $c = $a0 + $b + ($a3 * $t + $a2) * $t * $t;

    $planet_data[] = new PlanetDataPrecise(
        "Saturn",
        $c - 360.0 * floor($c / 360.0),
        ($a1 * 0.009856263) + ($a2 + $a3) / 36525.0,
        (($b3 * $t + $b2) * $t + $b1) * $t + $b0,
        (($c3 * $t + $c2) * $t + $c1) * $t + $c0,
        (($d3 * $t + $d2) * $t + $d1) * $t + $d0,
        (($e3 * $t + $e2) * $t + $e1) * $t + $e0,
        $f,
        $g,
        $h,
        0
    );

    $a0 = $f11;
    $a1 = $f12;
    $a2 = $f13;
    $a3 = $f14;
    $b0 = $f21;
    $b1 = $f22;
    $b2 = $f23;
    $b3 = $f24;
    $c0 = $f31;
    $c1 = $f32a;
    $c2 = $f33;
    $c3 = $f34;
    $d0 = $f41;
    $d1 = $f42;
    $d2 = $f43;
    $d3 = $f44;
    $e0 = $f51;
    $e1 = $f52;
    $e2 = $f53;
    $e3 = $f54;
    $f = $f61;
    $g = $f62;
    $h = $f63;

    $aa = $a1 * $t;
    $b = 360.0 * ($aa - floor($aa));
    $c = $a0 + $b + ($a3 * $t + $a2) * $t * $t;

    $planet_data[] = new PlanetDataPrecise(
        "Uranus",
        $c - 360.0 * floor($c / 360.0),
        ($a1 * 0.009856263) + ($a2 + $a3) / 36525.0,
        (($b3 * $t + $b2) * $t + $b1) * $t + $b0,
        (($c3 * $t + $c2) * $t + $c1) * $t + $c0,
        (($d3 * $t + $d2) * $t + $d1) * $t + $d0,
        (($e3 * $t + $e2) * $t + $e1) * $t + $e0,
        $f,
        $g,
        $h,
        0
    );

    $a0 = $g11;
    $a1 = $g12;
    $a2 = $g13;
    $a3 = $g14;
    $b0 = $g21;
    $b1 = $g22;
    $b2 = $g23;
    $b3 = $g24;
    $c0 = $g31;
    $c1 = $g32;
    $c2 = $g33;
    $c3 = $g34;
    $d0 = $g41;
    $d1 = $g42;
    $d2 = $g43;
    $d3 = $g44;
    $e0 = $g51;
    $e1 = $g52;
    $e2 = $g53;
    $e3 = $g54;
    $f = $g61;
    $g = $g62;
    $h = $g63;

    $aa = $a1 * $t;
    $b = 360.0 * ($aa - floor($aa));
    $c = $a0 + $b + ($a3 * $t + $a2) * $t * $t;

    $planet_data[] = new PlanetDataPrecise(
        "Neptune",
        $c - 360.0 * floor($c / 360.0),
        ($a1 * 0.009856263) + ($a2 + $a3) / 36525.0,
        (($b3 * $t + $b2) * $t + $b1) * $t + $b0,
        (($c3 * $t + $c2) * $t + $c1) * $t + $c0,
        (($d3 * $t + $d2) * $t + $d1) * $t + $d0,
        (($e3 * $t + $e2) * $t + $e1) * $t + $e0,
        $f,
        $g,
        $h,
        0
    );

    $check_planet = new PlanetDataPrecise("NotFound", 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
    foreach ($planet_data as $planet_record) {
        if ($planet_record->name == $s) {
            $check_planet = $planet_record;
        }
    }

    if ($check_planet->name == "NotFound")
        return array(w_to_degrees(unwind(0)), w_to_degrees(unwind(0)), w_to_degrees(unwind(0)), w_to_degrees(unwind(0)), w_to_degrees(unwind(0)), w_to_degrees(unwind(0)), w_to_degrees(unwind(0)));

    $li = 0.0;
    $ms = sun_mean_anomaly($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $sr = deg2rad(sun_long($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr));
    $re = sun_dist($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $lg = $sr + pi();

    $l0 = 0.0;
    $s0 = 0.0;
    $p0 = 0.0;
    $vo = 0.0;
    $lp1 = 0.0;
    $ll = 0.0;
    $rd = 0.0;
    $pd = 0.0;
    $sp = 0.0;
    $ci = 0.0;

    for ($k = 1; $k <= 3; $k++) {
        foreach ($planet_data as $planet_record) {
            $planet_record->ap_value = deg2rad($planet_record->value1 - $planet_record->value3 - $li * $planet_record->value2);
        }

        $qa = 0.0;
        $qb = 0.0;
        $qc = 0.0;
        $qd = 0.0;
        $qe = 0.0;
        $qf = 0.0;
        $qg = 0.0;

        if ($s == "Mercury") {
            list($l4685_qa, $l4685_qb) = planet_long_l4685($planet_data);

            $qa = $l4685_qa;
            $qb = $l4685_qb;
        }

        if ($s == "Venus") {
            list($l4735_qa, $l4735_qb, $l4735_qc, $l4735_qe) = planet_long_l4735($planet_data, $ms, $t);

            $qa = $l4735_qa;
            $qb = $l4735_qb;
            $qc = $l4735_qc;
            $qe = $l4735_qe;
        }

        if ($s == "Mars") {
            list($l4810_a, $l4810_sa, $l4810_ca, $l4810_qc, $l4810_qe, $l4810_qa, $l4810_qb) = planet_long_l4810($planet_data, $ms);

            $qc = $l4810_qc;
            $qe = $l4810_qe;
            $qa = $l4810_qa;
            $qb = $l4810_qb;
        }


        $match_planet = new PlanetDataPrecise("NotFound", 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
        foreach ($planet_data as $planet_record) {
            if ($planet_record->name == $s) {
                $match_planet = $planet_record;
            }
        }

        if (in_array($s, ["Jupiter", "Saturn", "Uranus", "Neptune"])) {

            list($l4945_qa, $l4945_qb, $l4945_qc, $l4945_qd, $l4945_qe, $l4945_qf, $l4945_qg) = planet_long_l4945($t, $match_planet);

            $qa = $l4945_qa;
            $qb = $l4945_qb;
            $qc = $l4945_qc;
            $qd = $l4945_qd;
            $qe = $l4945_qe;
            $qf = $l4945_qf;
            $qg = $l4945_qg;
        }

        $ec = $match_planet->value4 + $qd;
        $am = $match_planet->ap_value + $qe;
        $at = true_anomaly($am, $ec);
        $pvv = ($match_planet->value7 + $qf) * (1.0 - $ec * $ec) / (1.0 + $ec * cos($at));
        $lp = w_to_degrees($at) + $match_planet->value3 + w_to_degrees($qc - $qe);
        $lp = deg2rad($lp);
        $om = deg2rad($match_planet->value6);
        $lo = $lp - $om;
        $so = sin($lo);
        $co = cos($lo);
        $inn = deg2rad($match_planet->value5);
        $pvv += $qb;
        $sp = $so * sin($inn);
        $y = $so * cos($inn);
        $ps = asin($sp) + $qg;
        $sp = sin($ps);
        $pd = atan2($y, $co) + $om + deg2rad($qa);
        $pd = unwind($pd);
        $ci = cos($ps);
        $rd = $pvv * $ci;
        $ll = $pd - $lg;
        $rh = $re * $re + $pvv * $pvv - 2.0 * $re * $pvv * $ci * cos($ll);
        $rh = sqrt($rh);
        $li = $rh * 0.005775518;

        if ($k == 1) {
            $l0 = $pd;
            $s0 = $ps;
            $p0 = $pvv;
            $vo = $rh;
            $lp1 = $lp;
        }
    }

    $l1 = sin($ll);
    $l2 = cos($ll);

    $ep = ($ip < 3)
        ? atan(-1.0 * $rd * $l1 / ($re - $rd * $l2)) + $lg + pi()
        : atan($re * $l1 / ($rd - $re * $l2)) + $pd;
    $ep = unwind($ep);

    $bp = atan($rd * $sp * sin($ep - $pd) / ($ci * $re * $l1));

    $planet_longitude = w_to_degrees(unwind($ep));
    $planet_latitude = w_to_degrees(unwind($bp));
    $planet_distance_au = $vo;
    $planet_h_long1 = w_to_degrees($lp1);
    $planet_h_long2 = w_to_degrees($l0);
    $planet_h_lat = w_to_degrees($s0);
    $planet_r_vec = $p0;

    return array($planet_longitude, $planet_latitude, $planet_distance_au, $planet_h_long1, $planet_h_long2, $planet_h_lat, $planet_r_vec);
}

/** Helper function for planet_coordinates() */
function planet_long_l4685($pl)
{
    $qa = 0.00204 * cos(5.0 * $pl[2]->ap_value - 2.0 * $pl[1]->ap_value + 0.21328);
    $qa += 0.00103 * cos(2.0 * $pl[2]->ap_value - $pl[1]->ap_value - 2.8046);
    $qa += 0.00091 * cos(2.0 * $pl[4]->ap_value - $pl[1]->ap_value - 0.64582);
    $qa += 0.00078 * cos(5.0 * $pl[2]->ap_value - 3.0 * $pl[1]->ap_value + 0.17692);

    $qb = 0.000007525 * cos(2.0 * $pl[4]->ap_value - $pl[1]->ap_value + 0.925251);
    $qb += 0.000006802 * cos(5.0 * $pl[2]->ap_value - 3.0 * $pl[1]->ap_value - 4.53642);
    $qb += 0.000005457 * cos(2.0 * $pl[2]->ap_value - 2.0 * $pl[1]->ap_value - 1.24246);
    $qb += 0.000003569 * cos(5.0 * $pl[2]->ap_value - $pl[1]->ap_value - 1.35699);

    return array($qa, $qb);
}

/** Helper function for planet_coordinates() */
function planet_long_l4735($pl, $ms, $t)
{
    $qc = 0.00077 * sin(4.1406 + $t * 2.6227);
    $qc = deg2rad($qc);
    $qe = $qc;

    $qa = 0.00313 * cos(2.0 * $ms - 2.0 * $pl[2]->ap_value - 2.587);
    $qa += 0.00198 * cos(3.0 * $ms - 3.0 * $pl[2]->ap_value + 0.044768);
    $qa += 0.00136 * cos($ms - $pl[2]->ap_value - 2.0788);
    $qa += 0.00096 * cos(3.0 * $ms - 2.0 * $pl[2]->ap_value - 2.3721);
    $qa += 0.00082 * cos($pl[4]->ap_value - $pl[2]->ap_value - 3.6318);

    $qb = 0.000022501 * cos(2.0 * $ms - 2.0 * $pl[2]->ap_value - 1.01592);
    $qb += 0.000019045 * cos(3.0 * $ms - 3.0 * $pl[2]->ap_value + 1.61577);
    $qb += 0.000006887 * cos($pl[4]->ap_value - $pl[2]->ap_value - 2.06106);
    $qb += 0.000005172 * cos($ms - $pl[2]->ap_value - 0.508065);
    $qb += 0.00000362 * cos(5.0 * $ms - 4.0 * $pl[2]->ap_value - 1.81877);
    $qb += 0.000003283 * cos(4.0 * $ms - 4.0 * $pl[2]->ap_value + 1.10851);
    $qb += 0.000003074 * cos(2.0 * $pl[4]->ap_value - 2.0 * $pl[2]->ap_value - 0.962846);

    return array($qa, $qb, $qc, $qe);
}

/** Helper function for planet_coordinates() */
function planet_long_l4810($pl, $ms)
{
    $a = 3.0 * $pl[4]->ap_value - 8.0 * $pl[3]->ap_value + 4.0 * $ms;
    $sa = sin($a);
    $ca = cos($a);
    $qc = - (0.01133 * $sa + 0.00933 * $ca);
    $qc = deg2rad($qc);
    $qe = $qc;

    $qa = 0.00705 * cos($pl[4]->ap_value - $pl[3]->ap_value - 0.85448);
    $qa += 0.00607 * cos(2.0 * $pl[4]->ap_value - $pl[3]->ap_value - 3.2873);
    $qa += 0.00445 * cos(2.0 * $pl[4]->ap_value - 2.0 * $pl[3]->ap_value - 3.3492);
    $qa += 0.00388 * cos($ms - 2.0 * $pl[3]->ap_value + 0.35771);
    $qa += 0.00238 * cos($ms - $pl[3]->ap_value + 0.61256);
    $qa += 0.00204 * cos(2.0 * $ms - 3.0 * $pl[3]->ap_value + 2.7688);
    $qa += 0.00177 * cos(3.0 * $pl[3]->ap_value - $pl[2]->ap_value - 1.0053);
    $qa += 0.00136 * cos(2.0 * $ms - 4.0 * $pl[3]->ap_value + 2.6894);
    $qa += 0.00104 * cos($pl[4]->ap_value + 0.30749);

    $qb = 0.000053227 * cos($pl[4]->ap_value - $pl[3]->ap_value + 0.717864);
    $qb += 0.000050989 * cos(2.0 * $pl[4]->ap_value - 2.0 * $pl[3]->ap_value - 1.77997);
    $qb += 0.000038278 * cos(2.0 * $pl[4]->ap_value - $pl[3]->ap_value - 1.71617);
    $qb += 0.000015996 * cos($ms - $pl[3]->ap_value - 0.969618);
    $qb += 0.000014764 * cos(2.0 * $ms - 3.0 * $pl[3]->ap_value + 1.19768);
    $qb += 0.000008966 * cos($pl[4]->ap_value - 2.0 * $pl[3]->ap_value + 0.761225);
    $qb += 0.000007914 * cos(3.0 * $pl[4]->ap_value - 2.0 * $pl[3]->ap_value - 2.43887);
    $qb += 0.000007004 * cos(2.0 * $pl[4]->ap_value - 3.0 * $pl[3]->ap_value - 1.79573);
    $qb += 0.00000662 * cos($ms - 2.0 * $pl[3]->ap_value + 1.97575);
    $qb += 0.00000493 * cos(3.0 * $pl[4]->ap_value - 3.0 * $pl[3]->ap_value - 1.33069);
    $qb += 0.000004693 * cos(3.0 * $ms - 5.0 * $pl[3]->ap_value + 3.32665);
    $qb += 0.000004571 * cos(2.0 * $ms - 4.0 * $pl[3]->ap_value + 4.27086);
    $qb += 0.000004409 * cos(3.0 * $pl[4]->ap_value - $pl[3]->ap_value - 2.02158);

    return array($a, $sa, $ca, $qc, $qe, $qa, $qb);
}

/** Helper function for planet_coordinates() */
function planet_long_l4945($t, $planet)
{
    $qa = 0.0;
    $qb = 0.0;
    $qc = 0.0;
    $qd = 0.0;
    $qe = 0.0;
    $qf = 0.0;
    $qg = 0.0;
    $vk = 0.0;
    $ja = 0.0;
    $jb = 0.0;
    $jc = 0.0;

    $j1 = $t / 5.0 + 0.1;
    $j2 = unwind(4.14473 + 52.9691 * $t);
    $j3 = unwind(4.641118 + 21.32991 * $t);
    $j4 = unwind(4.250177 + 7.478172 * $t);
    $j5 = 5.0 * $j3 - 2.0 * $j2;
    $j6 = 2.0 * $j2 - 6.0 * $j3 + 3.0 * $j4;

    if (in_array($planet->name, ["Mercury", "Venus", "Mars"])) {
        return array($qa, $qb, $qc, $qd, $qe, $qf, $qg);
    }

    if (in_array($planet->name, ["Jupiter", "Saturn"])) {
        $j7 = $j3 - $j2;
        $u1 = sin($j3);
        $u2 = cos($j3);
        $u3 = sin(2.0 * $j3);
        $u4 = cos(2.0 * $j3);
        $u5 = sin($j5);
        $u6 = cos($j5);
        $u7 = sin(2.0 * $j5);
        $u8a = sin($j6);
        $u9 = sin($j7);
        $ua = cos($j7);
        $ub = sin(2.0 * $j7);
        $uc = cos(2.0 * $j7);
        $ud = sin(3.0 * $j7);
        $ue = cos(3.0 * $j7);
        $uf = sin(4.0 * $j7);
        $ug = cos(4.0 * $j7);
        $vh = cos(5.0 * $j7);

        if ($planet->name == "Saturn") {
            $ui = sin(3.0 * $j3);
            $uj = cos(3.0 * $j3);
            $uk = sin(4.0 * $j3);
            $ul = cos(4.0 * $j3);
            $vi = cos(2.0 * $j5);
            $un = sin(5.0 * $j7);
            $j8 = $j4 - $j3;
            $uo = sin(2.0 * $j8);
            $up = cos(2.0 * $j8);
            $uq = sin(3.0 * $j8);
            $ur = cos(3.0 * $j8);

            $qc = 0.007581 * $u7 - 0.007986 * $u8a - 0.148811 * $u9;
            $qc -= (0.814181 - (0.01815 - 0.016714 * $j1) * $j1) * $u5;
            $qc -= (0.010497 - (0.160906 - 0.0041 * $j1) * $j1) * $u6;
            $qc = $qc - 0.015208 * $ud - 0.006339 * $uf - 0.006244 * $u1;
            $qc = $qc - 0.0165 * $ub * $u1 - 0.040786 * $ub;
            $qc = $qc + (0.008931 + 0.002728 * $j1) * $u9 * $u1 - 0.005775 * $ud * $u1;
            $qc = $qc + (0.081344 + 0.003206 * $j1) * $ua * $u1 + 0.015019 * $uc * $u1;
            $qc = $qc + (0.085581 + 0.002494 * $j1) * $u9 * $u2 + 0.014394 * $uc * $u2;
            $qc = $qc + (0.025328 - 0.003117 * $j1) * $ua * $u2 + 0.006319 * $ue * $u2;
            $qc = $qc + 0.006369 * $u9 * $u3 + 0.009156 * $ub * $u3 + 0.007525 * $uq * $u3;
            $qc = $qc - 0.005236 * $ua * $u4 - 0.007736 * $uc * $u4 - 0.007528 * $ur * $u4;
            $qc = deg2rad($qc);

            $qd = (-7927.0 + (2548.0 + 91.0 * $j1) * $j1) * $u5;
            $qd = $qd + (13381.0 + (1226.0 - 253.0 * $j1) * $j1) * $u6 + (248.0 - 121.0 * $j1) * $u7;
            $qd = $qd - (305.0 + 91.0 * $j1) * $vi + 412.0 * $ub + 12415.0 * $u1;
            $qd = $qd + (390.0 - 617.0 * $j1) * $u9 * $u1 + (165.0 - 204.0 * $j1) * $ub * $u1;
            $qd = $qd + 26599.0 * $ua * $u1 - 4687.0 * $uc * $u1 - 1870.0 * $ue * $u1 - 821.0 * $ug * $u1;
            $qd = $qd - 377.0 * $vh * $u1 + 497.0 * $up * $u1 + (163.0 - 611.0 * $j1) * $u2;
            $qd = $qd - 12696.0 * $u9 * $u2 - 4200.0 * $ub * $u2 - 1503.0 * $ud * $u2 - 619.0 * $uf * $u2;
            $qd = $qd - 268.0 * $un * $u2 - (282.0 + 1306.0 * $j1) * $ua * $u2;
            $qd = $qd + (-86.0 + 230.0 * $j1) * $uc * $u2 + 461.0 * $uo * $u2 - 350.0 * $u3;
            $qd = $qd + (2211.0 - 286.0 * $j1) * $u9 * $u3 - 2208.0 * $ub * $u3 - 568.0 * $ud * $u3;
            $qd = $qd - 346.0 * $uf * $u3 - (2780.0 + 222.0 * $j1) * $ua * $u3;
            $qd = $qd + (2022.0 + 263.0 * $j1) * $uc * $u3 + 248.0 * $ue * $u3 + 242.0 * $uq * $u3;
            $qd = $qd + 467.0 * $ur * $u3 - 490.0 * $u4 - (2842.0 + 279.0 * $j1) * $u9 * $u4;
            $qd = $qd + (128.0 + 226.0 * $j1) * $ub * $u4 + 224.0 * $ud * $u4;
            $qd = $qd + (-1594.0 + 282.0 * $j1) * $ua * $u4 + (2162.0 - 207.0 * $j1) * $uc * $u4;
            $qd = $qd + 561.0 * $ue * $u4 + 343.0 * $ug * $u4 + 469.0 * $uq * $u4 - 242.0 * $ur * $u4;
            $qd = $qd - 205.0 * $u9 * $ui + 262.0 * $ud * $ui + 208.0 * $ua * $uj - 271.0 * $ue * $uj;
            $qd = $qd - 382.0 * $ue * $uk - 376.0 * $ud * $ul;
            $qd *= 0.0000001;

            $vk = (0.077108 + (0.007186 - 0.001533 * $j1) * $j1) * $u5;
            $vk -= 0.007075 * $u9;
            $vk += (0.045803 - (0.014766 + 0.000536 * $j1) * $j1) * $u6;
            $vk = $vk - 0.072586 * $u2 - 0.075825 * $u9 * $u1 - 0.024839 * $ub * $u1;
            $vk = $vk - 0.008631 * $ud * $u1 - 0.150383 * $ua * $u2;
            $vk = $vk + 0.026897 * $uc * $u2 + 0.010053 * $ue * $u2;
            $vk = $vk - (0.013597 + 0.001719 * $j1) * $u9 * $u3 + 0.011981 * $ub * $u4;
            $vk -= (0.007742 - 0.001517 * $j1) * $ua * $u3;
            $vk += (0.013586 - 0.001375 * $j1) * $uc * $u3;
            $vk -= (0.013667 - 0.001239 * $j1) * $u9 * $u4;
            $vk += (0.014861 + 0.001136 * $j1) * $ua * $u4;
            $vk -= (0.013064 + 0.001628 * $j1) * $uc * $u4;
            $qe = $qc - (deg2rad($vk) / $planet->value4);

            $qf = 572.0 * $u5 - 1590.0 * $ub * $u2 + 2933.0 * $u6 - 647.0 * $ud * $u2;
            $qf = $qf + 33629.0 * $ua - 344.0 * $uf * $u2 - 3081.0 * $uc + 2885.0 * $ua * $u2;
            $qf = $qf - 1423.0 * $ue + (2172.0 + 102.0 * $j1) * $uc * $u2 - 671.0 * $ug;
            $qf = $qf + 296.0 * $ue * $u2 - 320.0 * $vh - 267.0 * $ub * $u3 + 1098.0 * $u1;
            $qf = $qf - 778.0 * $ua * $u3 - 2812.0 * $u9 * $u1 + 495.0 * $uc * $u3 + 688.0 * $ub * $u1;
            $qf = $qf + 250.0 * $ue * $u3 - 393.0 * $ud * $u1 - 856.0 * $u9 * $u4 - 228.0 * $uf * $u1;
            $qf = $qf + 441.0 * $ub * $u4 + 2138.0 * $ua * $u1 + 296.0 * $uc * $u4 - 999.0 * $uc * $u1;
            $qf = $qf + 211.0 * $ue * $u4 - 642.0 * $ue * $u1 - 427.0 * $u9 * $ui - 325.0 * $ug * $u1;
            $qf = $qf + 398.0 * $ud * $ui - 890.0 * $u2 + 344.0 * $ua * $uj + 2206.0 * $u9 * $u2;
            $qf -= 427.0 * $ue * $uj;
            $qf *= 0.000001;

            $qg = 0.000747 * $ua * $u1 + 0.001069 * $ua * $u2 + 0.002108 * $ub * $u3;
            $qg = $qg + 0.001261 * $uc * $u3 + 0.001236 * $ub * $u4 - 0.002075 * $uc * $u4;
            $qg = deg2rad($qg);

            return array($qa, $qb, $qc, $qd, $qe, $qf, $qg);
        }

        $qc = (0.331364 - (0.010281 + 0.004692 * $j1) * $j1) * $u5;
        $qc += (0.003228 - (0.064436 - 0.002075 * $j1) * $j1) * $u6;
        $qc -= (0.003083 + (0.000275 - 0.000489 * $j1) * $j1) * $u7;
        $qc = $qc + 0.002472 * $u8a + 0.013619 * $u9 + 0.018472 * $ub;
        $qc = $qc + 0.006717 * $ud + 0.002775 * $uf + 0.006417 * $ub * $u1;
        $qc = $qc + (0.007275 - 0.001253 * $j1) * $u9 * $u1 + 0.002439 * $ud * $u1;
        $qc = $qc - (0.035681 + 0.001208 * $j1) * $u9 * $u2 - 0.003767 * $uc * $u1;
        $qc = $qc - (0.033839 + 0.001125 * $j1) * $ua * $u1 - 0.004261 * $ub * $u2;
        $qc = $qc + (0.001161 * $j1 - 0.006333) * $ua * $u2 + 0.002178 * $u2;
        $qc = $qc - 0.006675 * $uc * $u2 - 0.002664 * $ue * $u2 - 0.002572 * $u9 * $u3;
        $qc = $qc - 0.003567 * $ub * $u3 + 0.002094 * $ua * $u4 + 0.003342 * $uc * $u4;
        $qc = deg2rad($qc);

        $qd = (3606.0 + (130.0 - 43.0 * $j1) * $j1) * $u5 + (1289.0 - 580.0 * $j1) * $u6;
        $qd = $qd - 6764.0 * $u9 * $u1 - 1110.0 * $ub * $u1 - 224.0 * $ud * $u1 - 204.0 * $u1;
        $qd = $qd + (1284.0 + 116.0 * $j1) * $ua * $u1 + 188.0 * $uc * $u1;
        $qd = $qd + (1460.0 + 130.0 * $j1) * $u9 * $u2 + 224.0 * $ub * $u2 - 817.0 * $u2;
        $qd = $qd + 6074.0 * $u2 * $ua + 992.0 * $uc * $u2 + 508.0 * $ue * $u2 + 230.0 * $ug * $u2;
        $qd = $qd + 108.0 * $vh * $u2 - (956.0 + 73.0 * $j1) * $u9 * $u3 + 448.0 * $ub * $u3;
        $qd = $qd + 137.0 * $ud * $u3 + (108.0 * $j1 - 997.0) * $ua * $u3 + 480.0 * $uc * $u3;
        $qd = $qd + 148.0 * $ue * $u3 + (99.0 * $j1 - 956.0) * $u9 * $u4 + 490.0 * $ub * $u4;
        $qd = $qd + 158.0 * $ud * $u4 + 179.0 * $u4 + (1024.0 + 75.0 * $j1) * $ua * $u4;
        $qd = $qd - 437.0 * $uc * $u4 - 132.0 * $ue * $u4;
        $qd *= 0.0000001;

        $vk = (0.007192 - 0.003147 * $j1) * $u5 - 0.004344 * $u1;
        $vk += ($j1 * (0.000197 * $j1 - 0.000675) - 0.020428) * $u6;
        $vk = $vk + 0.034036 * $ua * $u1 + (0.007269 + 0.000672 * $j1) * $u9 * $u1;
        $vk = $vk + 0.005614 * $uc * $u1 + 0.002964 * $ue * $u1 + 0.037761 * $u9 * $u2;
        $vk = $vk + 0.006158 * $ub * $u2 - 0.006603 * $ua * $u2 - 0.005356 * $u9 * $u3;
        $vk = $vk + 0.002722 * $ub * $u3 + 0.004483 * $ua * $u3;
        $vk = $vk - 0.002642 * $uc * $u3 + 0.004403 * $u9 * $u4;
        $vk = $vk - 0.002536 * $ub * $u4 + 0.005547 * $ua * $u4 - 0.002689 * $uc * $u4;
        $qe = $qc - (deg2rad($vk) / $planet->value4);

        $qf = 205.0 * $ua - 263.0 * $u6 + 693.0 * $uc + 312.0 * $ue + 147.0 * $ug + 299.0 * $u9 * $u1;
        $qf = $qf + 181.0 * $uc * $u1 + 204.0 * $ub * $u2 + 111.0 * $ud * $u2 - 337.0 * $ua * $u2;
        $qf -= 111.0 * $uc * $u2;
        $qf *= 0.000001;

        return array($qa, $qb, $qc, $qd, $qe, $qf, $qg);
    }

    if (in_array($planet->name, ["Uranus", "Neptune"])) {
        $j8 = unwind(1.46205 + 3.81337 * $t);
        $j9 = 2.0 * $j8 - $j4;
        $vj = sin($j9);
        $uu = sin($j9);
        $uv = sin(2.0 * $j9);
        $uw = cos(2.0 * $j9);

        if ($planet->name == "Neptune") {
            $ja = $j8 - $j2;
            $jb = $j8 - $j3;
            $jc = $j8 - $j4;
            $qc = (0.001089 * $j1 - 0.589833) * $vj;
            $qc = $qc + (0.004658 * $j1 - 0.056094) * $uu - 0.024286 * $uv;
            $qc = deg2rad($qc);

            $vk = 0.024039 * $vj - 0.025303 * $uu + 0.006206 * $uv;
            $vk -= 0.005992 * $uw;
            $qe = $qc - (deg2rad($vk) / $planet->value4);

            $qd = 4389.0 * $vj + 1129.0 * $uv + 4262.0 * $uu + 1089.0 * $uw;
            $qd *= 0.0000001;

            $qf = 8189.0 * $uu - 817.0 * $vj + 781.0 * $uw;
            $qf *= 0.000001;

            $vd = sin(2.0 * $jc);
            $ve = cos(2.0 * $jc);
            $vf = sin($j8);
            $vg = cos($j8);
            $qa = -0.009556 * sin($ja) - 0.005178 * sin($jb);
            $qa = $qa + 0.002572 * $vd - 0.002972 * $ve * $vf - 0.002833 * $vd * $vg;

            $qg = 0.000336 * $ve * $vf + 0.000364 * $vd * $vg;
            $qg = deg2rad($qg);

            $qb = -40596.0 + 4992.0 * cos($ja) + 2744.0 * cos($jb);
            $qb = $qb + 2044.0 * cos($jc) + 1051.0 * $ve;
            $qb *= 0.000001;

            return array($qa, $qb, $qc, $qd, $qe, $qf, $qg);
        }

        $ja = $j4 - $j2;
        $jb = $j4 - $j3;
        $jc = $j8 - $j4;
        $qc = (0.864319 - 0.001583 * $j1) * $vj;
        $qc = $qc + (0.082222 - 0.006833 * $j1) * $uu + 0.036017 * $uv;
        $qc = $qc - 0.003019 * $uw + 0.008122 * sin($j6);
        $qc = deg2rad($qc);

        $vk = 0.120303 * $vj + 0.006197 * $uv;
        $vk += (0.019472 - 0.000947 * $j1) * $uu;
        $qe = $qc - (deg2rad($vk) / $planet->value4);

        $qd = (163.0 * $j1 - 3349.0) * $vj + 20981.0 * $uu + 1311.0 * $uw;
        $qd *= 0.0000001;

        $qf = -0.003825 * $uu;

        $qa = (-0.038581 + (0.002031 - 0.00191 * $j1) * $j1) * cos($j4 + $jb);
        $qa += (0.010122 - 0.000988 * $j1) * sin($j4 + $jb);
        $a = (0.034964 - (0.001038 - 0.000868 * $j1) * $j1) * cos(2.0 * $j4 + $jb);
        $qa = $a + $qa + 0.005594 * sin($j4 + 3.0 * $jc) - 0.014808 * sin($ja);
        $qa = $qa - 0.005794 * sin($jb) + 0.002347 * cos($jb);
        $qa = $qa + 0.009872 * sin($jc) + 0.008803 * sin(2.0 * $jc);
        $qa -= 0.004308 * sin(3.0 * $jc);

        $ux = sin($jb);
        $uy = cos($jb);
        $uz = sin($j4);
        $va = cos($j4);
        $vb = sin(2.0 * $j4);
        $vc = cos(2.0 * $j4);
        $qg = (0.000458 * $ux - 0.000642 * $uy - 0.000517 * cos(4.0 * $jc)) * $uz;
        $qg -= (0.000347 * $ux + 0.000853 * $uy + 0.000517 * sin(4.0 * $jb)) * $va;
        $qg += 0.000403 * (cos(2.0 * $jc) * $vb + sin(2.0 * $jc) * $vc);
        $qg = deg2rad($qg);

        $qb = -25948.0 + 4985.0 * cos($ja) - 1230.0 * $va + 3354.0 * $uy;
        $qb = $qb + 904.0 * cos(2.0 * $jc) + 894.0 * (cos($jc) - cos(3.0 * $jc));
        $qb += (5795.0 * $va - 1165.0 * $uz + 1388.0 * $vc) * $ux;
        $qb += (1351.0 * $va + 5702.0 * $uz + 1388.0 * $vb) * $uy;
        $qb *= 0.000001;

        return array($qa, $qb, $qc, $qd, $qe, $qf, $qg);
    }

    return array($qa, $qb, $qc, $qd, $qe, $qf, $qg);
}

/**
 * For W, in radians, return S, also in radians.
 * 
 * Original macro name: SolveCubic
 */
function solve_cubic($w)
{
    $s = $w / 3.0;

    while (true) {
        $s2 = $s * $s;
        $d = ($s2 + 3.0) * $s - $w;

        if (abs($d) < 0.000001) {
            return $s;
        }

        $s = ((2.0 * $s * $s2) + $w) / (3.0 * ($s2 + 1.0));
    }
}

/**
 * Calculate longitude, latitude, and distance of parabolic-orbit comet.
 *
 * Original macro names: PcometLong, PcometLat, PcometDist
 */
function p_comet_long_lat_dist($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr, $td, $tm, $ty, $q, $i, $p, $n)
{
    $gd = local_civil_time_greenwich_day($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gm = local_civil_time_greenwich_month($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gy = local_civil_time_greenwich_year($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $ut = local_civil_time_to_universal_time($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $tpe = ($ut / 365.242191) + civil_date_to_julian_date($gd, $gm, $gy) - civil_date_to_julian_date($td, $tm, $ty);
    $lg = deg2rad(sun_long($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr) + 180.0);
    $re = sun_dist($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);

    $rh2 = 0.0;
    $rd = 0.0;
    $s3 = 0.0;
    $c3 = 0.0;
    $lc = 0.0;
    $s2 = 0.0;
    $c2 = 0.0;

    for ($k = 1; $k < 3; $k++) {
        $s = solve_cubic(0.0364911624 * $tpe / ($q * sqrt($q)));
        $nu = 2.0 * atan($s);
        $r = $q * (1.0 + $s * $s);
        $l = $nu + deg2rad($p);
        $s1 = sin($l);
        $c1 = cos($l);
        $i1 = deg2rad($i);
        $s2 = $s1 * sin($i1);
        $ps = asin($s2);
        $y = $s1 * cos($i1);
        $lc = atan2($y, $c1) + deg2rad($n);
        $c2 = cos($ps);
        $rd = $r * $c2;
        $ll = $lc - $lg;
        $c3 = cos($ll);
        $s3 = sin($ll);
        $rh = sqrt(($re * $re) + ($r * $r) - (2.0 * $re * $rd * $c3 * cos($ps)));
        if ($k == 1) {
            $rh2 = sqrt(($re * $re) + ($r * $r) - (2.0 * $re * $r * cos($ps) * cos($l + deg2rad($n) - $lg)));
        }
    }

    $ep = ($rd < $re)
        ? atan(-$rd * $s3 / ($re - ($rd * $c3))) + $lg + 3.141592654
        : atan($re * $s3 / ($rd - ($re * $c3))) + $lc;
    $ep = unwind($ep);

    $tb = $rd * $s2 * sin($ep - $lc) / ($c2 * $re * $s3);
    $bp = atan($tb);

    $cometLongDeg = w_to_degrees($ep);
    $cometLatDeg = w_to_degrees($bp);
    $cometDistAU = $rh2;

    return array($cometLongDeg, $cometLatDeg, $cometDistAU);
}

/**
 * Calculate longitude, latitude, and horizontal parallax of the Moon.
 * 
 * Original macro names: MoonLong, MoonLat, MoonHP
 */
function moon_long_lat_hp($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr)
{
    $ut = local_civil_time_to_universal_time($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gd = local_civil_time_greenwich_day($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gm = local_civil_time_greenwich_month($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gy = local_civil_time_greenwich_year($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $t = ((civil_date_to_julian_date($gd, $gm, $gy) - 2415020.0) / 36525.0) + ($ut / 876600.0);
    $t2 = $t * $t;

    $m1 = 27.32158213;
    $m2 = 365.2596407;
    $m3 = 27.55455094;
    $m4 = 29.53058868;
    $m5 = 27.21222039;
    $m6 = 6798.363307;
    $q = civil_date_to_julian_date($gd, $gm, $gy) - 2415020.0 + ($ut / 24.0);
    $m1 = $q / $m1;
    $m2 = $q / $m2;
    $m3 = $q / $m3;
    $m4 = $q / $m4;
    $m5 = $q / $m5;
    $m6 = $q / $m6;
    $m1 = 360.0 * ($m1 - floor($m1));
    $m2 = 360.0 * ($m2 - floor($m2));
    $m3 = 360.0 * ($m3 - floor($m3));
    $m4 = 360.0 * ($m4 - floor($m4));
    $m5 = 360.0 * ($m5 - floor($m5));
    $m6 = 360.0 * ($m6 - floor($m6));

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
    $ms -= 0.001778 * $s1;
    $md = $md + 0.000817 * $s1 + $s3 + 0.002541 * $s2;
    $mf = $mf + $s3 - 0.024691 * $s2 - 0.004328 * $s4;
    $me1 = $me1 + 0.002011 * $s1 + $s3 + 0.001964 * $s2;
    $e = 1.0 - (0.002495 + 0.00000752 * $t) * $t;
    $e2 = $e * $e;
    $ml = deg2rad($ml);
    $ms = deg2rad($ms);
    $na = deg2rad($na);
    $me1 = deg2rad($me1);
    $mf = deg2rad($mf);
    $md = deg2rad($md);

    // Longitude-specific
    $l = 6.28875 * sin($md) + 1.274018 * sin(2.0 * $me1 - $md);
    $l = $l + 0.658309 * sin(2.0 * $me1) + 0.213616 * sin(2.0 * $md);
    $l = $l - $e * 0.185596 * sin($ms) - 0.114336 * sin(2.0 * $mf);
    $l += 0.058793 * sin(2.0 * ($me1 - $md));
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
    $l += $e * 0.000761 * sin(4.0 * $me1 - $ms - 2.0 * $md);
    $l += $e2 * 0.000704 * sin($md - 2.0 * ($ms + $me1));
    $l += $e * 0.000693 * sin($ms - 2.0 * ($md - $me1));
    $l += $e * 0.000598 * sin(2.0 * ($me1 - $mf) - $ms);
    $l = $l + 0.00055 * sin($md + 4.0 * $me1) + 0.000538 * sin(4.0 * $md);
    $l = $l + $e * 0.000521 * sin(4.0 * $me1 - $ms) + 0.000486 * sin(2.0 * $md - $me1);
    $l += $e2 * 0.000717 * sin($md - 2.0 * $ms);
    $mm = unwind($ml + deg2rad($l));

    // Latitude-specific
    $g = 5.128189 * sin($mf) + 0.280606 * sin($md + $mf);
    $g = $g + 0.277693 * sin($md - $mf) + 0.173238 * sin(2.0 * $me1 - $mf);
    $g = $g + 0.055413 * sin(2.0 * $me1 + $mf - $md) + 0.046272 * sin(2.0 * $me1 - $mf - $md);
    $g = $g + 0.032573 * sin(2.0 * $me1 + $mf) + 0.017198 * sin(2.0 * $md + $mf);
    $g = $g + 0.009267 * sin(2.0 * $me1 + $md - $mf) + 0.008823 * sin(2.0 * $md - $mf);
    $g = $g + $e * 0.008247 * sin(2.0 * $me1 - $ms - $mf) + 0.004323 * sin(2.0 * ($me1 - $md) - $mf);
    $g = $g + 0.0042 * sin(2.0 * $me1 + $mf + $md) + $e * 0.003372 * sin($mf - $ms - 2.0 * $me1);
    $g += $e * 0.002472 * sin(2.0 * $me1 + $mf - $ms - $md);
    $g += $e * 0.002222 * sin(2.0 * $me1 + $mf - $ms);
    $g += $e * 0.002072 * sin(2.0 * $me1 - $mf - $ms - $md);
    $g = $g + $e * 0.001877 * sin($mf - $ms + $md) + 0.001828 * sin(4.0 * $me1 - $mf - $md);
    $g = $g - $e * 0.001803 * sin($mf + $ms) - 0.00175 * sin(3.0 * $mf);
    $g = $g + $e * 0.00157 * sin($md - $ms - $mf) - 0.001487 * sin($mf + $me1);
    $g = $g - $e * 0.001481 * sin($mf + $ms + $md) + $e * 0.001417 * sin($mf - $ms - $md);
    $g = $g + $e * 0.00135 * sin($mf - $ms) + 0.00133 * sin($mf - $me1);
    $g = $g + 0.001106 * sin($mf + 3.0 * $md) + 0.00102 * sin(4.0 * $me1 - $mf);
    $g = $g + 0.000833 * sin($mf + 4.0 * $me1 - $md) + 0.000781 * sin($md - 3.0 * $mf);
    $g = $g + 0.00067 * sin($mf + 4.0 * $me1 - 2.0 * $md) + 0.000606 * sin(2.0 * $me1 - 3.0 * $mf);
    $g += 0.000597 * sin(2.0 * ($me1 + $md) - $mf);
    $g = $g + $e * 0.000492 * sin(2.0 * $me1 + $md - $ms - $mf) + 0.00045 * sin(2.0 * ($md - $me1) - $mf);
    $g = $g + 0.000439 * sin(3.0 * $md - $mf) + 0.000423 * sin($mf + 2.0 * ($me1 + $md));
    $g = $g + 0.000422 * sin(2.0 * $me1 - $mf - 3.0 * $md) - $e * 0.000367 * sin($ms + $mf + 2.0 * $me1 - $md);
    $g = $g - $e * 0.000353 * sin($ms + $mf + 2.0 * $me1) + 0.000331 * sin($mf + 4.0 * $me1);
    $g += $e * 0.000317 * sin(2.0 * $me1 + $mf - $ms + $md);
    $g = $g + $e2 * 0.000306 * sin(2.0 * ($me1 - $ms) - $mf) - 0.000283 * sin($md + 3.0 * $mf);
    $w1 = 0.0004664 * cos($na);
    $w2 = 0.0000754 * cos($c);
    $bm = deg2rad($g) * (1.0 - $w1 - $w2);

    // Horizontal parallax-specific
    $pm = 0.950724 + 0.051818 * cos($md) + 0.009531 * cos(2.0 * $me1 - $md);
    $pm = $pm + 0.007843 * cos(2.0 * $me1) + 0.002824 * cos(2.0 * $md);
    $pm = $pm + 0.000857 * cos(2.0 * $me1 + $md) + $e * 0.000533 * cos(2.0 * $me1 - $ms);
    $pm += $e * 0.000401 * cos(2.0 * $me1 - $md - $ms);
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
    $pm += $e * 0.000019 * cos(4.0 * $me1 - $ms - $md);

    $moonLongDeg = w_to_degrees($mm);
    $moonLatDeg = w_to_degrees($bm);
    $moonHorPara = $pm;

    return array($moonLongDeg, $moonLatDeg, $moonHorPara);
}

/**
 * Calculate current phase of Moon.
 * 
 * Original macro name: MoonPhase
 */
function moon_phase_ma($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr)
{
    list($moonLongDeg, $moonLatDeg, $moonHorPara) = moon_long_lat_hp($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);

    $cd = cos(deg2rad(($moonLongDeg - sun_long($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr)))) * cos(deg2rad($moonLatDeg));

    $d = acos($cd);
    $sd = sin($d);
    $i = 0.1468 * $sd * (1.0 - 0.0549 * sin(moon_mean_anomaly($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr)));
    $i /= (1.0 - 0.0167 * sin(sun_mean_anomaly($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr)));
    $i = 3.141592654 - $d - deg2rad($i);
    $k = (1.0 + cos($i)) / 2.0;

    return round($k, 2);
}

/**
 * Calculate the Moon's mean anomaly.
 * 
 * Original macro name: MoonMeanAnomaly
 */
function moon_mean_anomaly($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr)
{
    $ut = local_civil_time_to_universal_time($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gd = local_civil_time_greenwich_day($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gm = local_civil_time_greenwich_month($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $gy = local_civil_time_greenwich_year($lh, $lm, $ls, $ds, $zc, $dy, $mn, $yr);
    $t = ((civil_date_to_julian_date($gd, $gm, $gy) - 2415020.0) / 36525.0) + ($ut / 876600.0);
    $t2 = $t * $t;

    $m1 = 27.32158213;
    $m2 = 365.2596407;
    $m3 = 27.55455094;
    $m4 = 29.53058868;
    $m5 = 27.21222039;
    $m6 = 6798.363307;
    $q = civil_date_to_julian_date($gd, $gm, $gy) - 2415020.0 + ($ut / 24.0);
    $m1 = $q / $m1;
    $m2 = $q / $m2;
    $m3 = $q / $m3;
    $m4 = $q / $m4;
    $m5 = $q / $m5;
    $m6 = $q / $m6;
    $m1 = 360.0 * ($m1 - floor($m1));
    $m2 = 360.0 * ($m2 - floor($m2));
    $m3 = 360.0 * ($m3 - floor($m3));
    $m4 = 360.0 * ($m4 - floor($m4));
    $m5 = 360.0 * ($m5 - floor($m5));
    $m6 = 360.0 * ($m6 - floor($m6));

    $ml = 270.434164 + $m1 - (0.001133 - 0.0000019 * $t) * $t2;
    $ms = 358.475833 + $m2 - (0.00015 + 0.0000033 * $t) * $t2;
    $md = 296.104608 + $m3 + (0.009192 + 0.0000144 * $t) * $t2;
    $na = 259.183275 - $m6 + (0.002078 + 0.0000022 * $t) * $t2;
    $a = deg2rad(51.2 + 20.2 * $t);
    $s1 = sin($a);
    $s2 = sin(deg2rad($na));
    $b = 346.56 + (132.87 - 0.0091731 * $t) * $t;
    $s3 = 0.003964 * sin(deg2rad($b));
    $c = deg2rad($na + 275.05 - 2.3 * $t);
    $md = $md + 0.000817 * $s1 + $s3 + 0.002541 * $s2;

    return deg2rad($md);
}
