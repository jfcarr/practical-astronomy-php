<?php

namespace PA\Coordinates;

include_once 'PAMacros.php';
include_once 'PAMathExtensions.php';

use PA\Macros as PA_Macros;
use PA\MathExtensions as PA_Math;

/**
 * Convert an Angle (degrees, minutes, and seconds) to Decimal Degrees
 */
function angle_to_decimal_degrees($degrees, $minutes, $seconds)
{
    $a = abs($seconds) / 60;
    $b = (abs($minutes) + $a) / 60;
    $c = abs($degrees) + $b;
    $d = ($degrees < 0 || $minutes < 0 || $seconds < 0) ? -$c : $c;

    return $d;
}

/**
 * Convert Decimal Degrees to an Angle (degrees, minutes, and seconds)
 */
function decimal_degrees_to_angle($decimalDegrees)
{
    $unsignedDecimal = abs($decimalDegrees);
    $totalSeconds = $unsignedDecimal * 3600;
    $seconds2DP = @round($totalSeconds % 60, 2);
    $correctedSeconds = ($seconds2DP == 60) ? 0 : $seconds2DP;
    $correctedRemainder = ($seconds2DP == 60) ? $totalSeconds + 60 : $totalSeconds;
    $minutes = floor($correctedRemainder / 60) % 60;
    $unsignedDegrees = floor($correctedRemainder / 3600);
    $signedDegrees = ($decimalDegrees < 0) ? -1 * $unsignedDegrees : $unsignedDegrees;

    return array($signedDegrees, $minutes, floor($correctedSeconds));
}

/**
 * Convert Right Ascension to Hour Angle
 */
function right_ascension_to_hour_angle($raHours, $raMinutes, $raSeconds, $lctHours, $lctMinutes, $lctSeconds, $isDaylightSavings, $zoneCorrection, $localDay, $localMonth, $localYear, $geographicalLongitude)
{
    $daylightSaving = ($isDaylightSavings) ? 1 : 0;

    $hourAngle = PA_Macros\right_ascension_to_hour_angle($raHours, $raMinutes, $raSeconds, $lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear, $geographicalLongitude);

    $hourAngleHours = PA_Macros\decimal_hours_hour($hourAngle);
    $hourAngleMinutes = PA_Macros\decimal_hours_minute($hourAngle);
    $hourAngleSeconds = PA_Macros\decimal_hours_second($hourAngle);

    return array($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds);
}

/**
 * Convert Hour Angle to Right Ascension
 */
function hour_angle_to_right_ascension($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $lctHours, $lctMinutes, $lctSeconds, $isDaylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear, $geographicalLongitude)
{
    $daylightSaving = ($isDaylightSaving) ? 1 : 0;

    $rightAscension = PA_Macros\hour_angle_to_right_ascension($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear, $geographicalLongitude);

    $rightAscensionHours = PA_Macros\decimal_hours_hour($rightAscension);
    $rightAscensionMinutes = PA_Macros\decimal_hours_minute($rightAscension);
    $rightAscensionSeconds = PA_Macros\decimal_hours_second($rightAscension);

    return array($rightAscensionHours, $rightAscensionMinutes, $rightAscensionSeconds);
}

/**
 * Convert Equatorial Coordinates to Horizon Coordinates
 */
function equatorial_coordinates_to_horizon_coordinates($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $declinationDegrees, $declinationMinutes, $declinationSeconds, $geographicalLatitude)
{
    $azimuthInDecimalDegrees = PA_Macros\equatorial_coordinates_to_azimuth($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $declinationDegrees, $declinationMinutes, $declinationSeconds, $geographicalLatitude);

    $altitudeInDecimalDegrees = PA_Macros\equatorial_coordinates_to_altitude($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $declinationDegrees, $declinationMinutes, $declinationSeconds, $geographicalLatitude);

    $azimuthDegrees = PA_Macros\decimal_degrees_degrees($azimuthInDecimalDegrees);
    $azimuthMinutes = PA_Macros\decimal_degrees_minutes($azimuthInDecimalDegrees);
    $azimuthSeconds = PA_Macros\decimal_degrees_seconds($azimuthInDecimalDegrees);

    $altitudeDegrees = PA_Macros\decimal_degrees_degrees($altitudeInDecimalDegrees);
    $altitudeMinutes = PA_Macros\decimal_degrees_minutes($altitudeInDecimalDegrees);
    $altitudeSeconds = PA_Macros\decimal_degrees_seconds($altitudeInDecimalDegrees);

    return array($azimuthDegrees, $azimuthMinutes, $azimuthSeconds, $altitudeDegrees, $altitudeMinutes, $altitudeSeconds);
}

/**
 * Convert Horizon Coordinates to Equatorial Coordinates
 */

function horizon_coordinates_to_equatorial_coordinates($azimuthDegrees, $azimuthMinutes, $azimuthSeconds, $altitudeDegrees, $altitudeMinutes, $altitudeSeconds, $geographicalLatitude)
{
    $hourAngleInDecimalDegrees = PA_Macros\horizon_coordinates_to_hour_angle($azimuthDegrees, $azimuthMinutes, $azimuthSeconds, $altitudeDegrees, $altitudeMinutes, $altitudeSeconds, $geographicalLatitude);

    $declinationInDecimalDegrees = PA_Macros\horizon_coordinates_to_declination($azimuthDegrees, $azimuthMinutes, $azimuthSeconds, $altitudeDegrees, $altitudeMinutes, $altitudeSeconds, $geographicalLatitude);

    $hourAngleHours = PA_Macros\decimal_hours_hour($hourAngleInDecimalDegrees);
    $hourAngleMinutes = PA_Macros\decimal_hours_minute($hourAngleInDecimalDegrees);
    $hourAngleSeconds = PA_Macros\decimal_hours_second($hourAngleInDecimalDegrees);

    $declinationDegrees = PA_Macros\decimal_degrees_degrees($declinationInDecimalDegrees);
    $declinationMinutes = PA_Macros\decimal_degrees_minutes($declinationInDecimalDegrees);
    $declinationSeconds = PA_Macros\decimal_degrees_seconds($declinationInDecimalDegrees);

    return array($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $declinationDegrees, $declinationMinutes, $declinationSeconds);
}

/**
 * Calculate Mean Obliquity of the Ecliptic for a Greenwich Date
 */
function mean_obliquity_of_the_ecliptic($greenwichDay, $greenwichMonth, $greenwichYear)
{
    $jd = PA_Macros\civil_date_to_julian_date($greenwichDay, $greenwichMonth, $greenwichYear);
    $mjd = $jd - 2451545;
    $t = $mjd / 36525;
    $de1 = $t * (46.815 + $t * (0.0006 - ($t * 0.00181)));
    $de2 = $de1 / 3600;

    return 23.439292 - $de2;
}

/**
 * Convert Ecliptic Coordinates to Equatorial Coordinates
 */
function ecliptic_coordinate_to_equatorial_coordinate($eclipticLongitudeDegrees, $eclipticLongitudeMinutes, $eclipticLongitudeSeconds, $eclipticLatitudeDegrees, $eclipticLatitudeMinutes, $eclipticLatitudeSeconds, $greenwichDay, $greenwichMonth, $greenwichYear)
{
    $eclonDeg = PA_Macros\degrees_minutes_seconds_to_decimal_degrees($eclipticLongitudeDegrees, $eclipticLongitudeMinutes, $eclipticLongitudeSeconds);
    $eclatDeg = PA_Macros\degrees_minutes_seconds_to_decimal_degrees($eclipticLatitudeDegrees, $eclipticLatitudeMinutes, $eclipticLatitudeSeconds);
    $eclonRad = PA_Math\degrees_to_radians($eclonDeg);
    $eclatRad = PA_Math\degrees_to_radians($eclatDeg);
    $obliqDeg = PA_Macros\obliq($greenwichDay, $greenwichMonth, $greenwichYear);
    $obliqRad = PA_Math\degrees_to_radians($obliqDeg);
    $sinDec = sin($eclatRad) * cos($obliqRad) + cos($eclatRad) * sin($obliqRad) * sin($eclonRad);
    $decRad = asin($sinDec);
    $decDeg = PA_Macros\degrees($decRad);
    $y = sin($eclonRad) * cos($obliqRad) - tan($eclatRad) * sin($obliqRad);
    $x = cos($eclonRad);
    $raRad = atan2($y, $x);
    $raDeg1 = PA_Macros\degrees($raRad);
    $raDeg2 = $raDeg1 - 360 * floor($raDeg1 / 360);
    $raHours = PA_Macros\decimal_degrees_to_degree_hours($raDeg2);

    $outRAHours = PA_Macros\decimal_hours_hour($raHours);
    $outRAMinutes = PA_Macros\decimal_hours_minute($raHours);
    $outRASeconds = PA_Macros\decimal_hours_second($raHours);
    $outDecDegrees = PA_Macros\decimal_degrees_degrees($decDeg);
    $outDecMinutes = PA_Macros\decimal_degrees_minutes($decDeg);
    $outDecSeconds = PA_Macros\decimal_degrees_seconds($decDeg);

    return array($outRAHours, $outRAMinutes, $outRASeconds, $outDecDegrees, $outDecMinutes, $outDecSeconds);
}

/**
 * Convert Equatorial Coordinates to Ecliptic Coordinates
 */
function equatorial_coordinate_to_ecliptic_coordinate($raHours, $raMinutes, $raSeconds, $decDegrees, $decMinutes, $decSeconds, $gwDay, $gwMonth, $gwYear)
{
    $raDeg = PA_Macros\degree_hours_to_decimal_degrees(PA_Macros\hours_minutes_seconds_to_decimal_hours($raHours, $raMinutes, $raSeconds));
    $decDeg = PA_Macros\degrees_minutes_seconds_to_decimal_degrees($decDegrees, $decMinutes, $decSeconds);
    $raRad = PA_Math\degrees_to_radians($raDeg);
    $decRad = PA_Math\degrees_to_radians($decDeg);
    $obliqDeg = PA_Macros\obliq($gwDay, $gwMonth, $gwYear);
    $obliqRad = PA_Math\degrees_to_radians($obliqDeg);
    $sinEclLat = sin($decRad) * cos($obliqRad) - cos($decRad) * sin($obliqRad) * sin($raRad);
    $eclLatRad = asin($sinEclLat);
    $eclLatDeg = PA_Macros\degrees($eclLatRad);
    $y = sin($raRad) * cos($obliqRad) + tan($decRad) * sin($obliqRad);
    $x = cos($raRad);
    $eclLongRad = atan2($y, $x);
    $eclLongDeg1 = PA_Macros\degrees($eclLongRad);
    $eclLongDeg2 = $eclLongDeg1 - 360 * floor($eclLongDeg1 / 360);

    $outEclLongDeg = PA_Macros\decimal_degrees_degrees($eclLongDeg2);
    $outEclLongMin = PA_Macros\decimal_degrees_minutes($eclLongDeg2);
    $outEclLongSec = PA_Macros\decimal_degrees_seconds($eclLongDeg2);
    $outEclLatDeg = PA_Macros\decimal_degrees_degrees($eclLatDeg);
    $outEclLatMin = PA_Macros\decimal_degrees_minutes($eclLatDeg);
    $outEclLatSec = PA_Macros\decimal_degrees_seconds($eclLatDeg);

    return array($outEclLongDeg, $outEclLongMin, $outEclLongSec, $outEclLatDeg, $outEclLatMin, $outEclLatSec);
}
