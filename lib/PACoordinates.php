<?php

namespace PA\Coordinates;

include 'PAMacros.php';
include 'PAUtils.php';

use PA\Macros as PA_Macros;
use PA\Utils as PA_Utils;

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
