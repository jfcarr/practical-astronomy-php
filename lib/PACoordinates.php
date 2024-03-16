<?php

namespace PA\Coordinates;

include_once 'PAMacros.php';
include_once 'PAMathExtensions.php';
include_once 'PATypes.php';

use PA\Macros as PA_Macros;
use PA\MathExtensions as PA_Math;
use PA\Types as PA_Types;

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

/**
 * Convert Equatorial Coordinates to Galactic Coordinates
 */
function equatorial_coordinate_to_galactic_coordinate($raHours, $raMinutes, $raSeconds, $decDegrees, $decMinutes, $decSeconds)
{
    $raDeg = PA_Macros\degree_hours_to_decimal_degrees(PA_Macros\hours_minutes_seconds_to_decimal_hours($raHours, $raMinutes, $raSeconds));
    $decDeg = PA_Macros\degrees_minutes_seconds_to_decimal_degrees($decDegrees, $decMinutes, $decSeconds);
    $raRad = PA_Math\degrees_to_radians($raDeg);
    $decRad = PA_Math\degrees_to_radians($decDeg);
    $sinB = cos($decRad) * cos(PA_Math\degrees_to_radians(27.4))  * cos($raRad - PA_Math\degrees_to_radians(192.25)) + sin($decRad) * sin(PA_Math\degrees_to_radians(27.4));
    $bRadians = asin($sinB);
    $bDeg = PA_Macros\degrees($bRadians);
    $y = sin($decRad) - $sinB * sin(PA_Math\degrees_to_radians(27.4));
    $x = cos($decRad) * sin($raRad - PA_Math\degrees_to_radians(192.25)) * cos(PA_Math\degrees_to_radians(27.4));
    $longDeg1 = PA_Macros\degrees(atan2($y, $x)) + 33;
    $longDeg2 = $longDeg1 - 360 * floor($longDeg1 / 360);

    $galLongDeg = PA_Macros\decimal_degrees_degrees($longDeg2);
    $galLongMin = PA_Macros\decimal_degrees_minutes($longDeg2);
    $galLongSec = PA_Macros\decimal_degrees_seconds($longDeg2);
    $galLatDeg = PA_Macros\decimal_degrees_degrees($bDeg);
    $galLatMin = PA_Macros\decimal_degrees_minutes($bDeg);
    $galLatSec = PA_Macros\decimal_degrees_seconds($bDeg);

    return array($galLongDeg, $galLongMin, $galLongSec, $galLatDeg, $galLatMin, $galLatSec);
}

/**
 * Convert Galactic Coordinates to Equatorial Coordinates
 */
function galactic_coordinate_to_equatorial_coordinate($galLongDeg, $galLongMin, $galLongSec, $galLatDeg, $galLatMin, $galLatSec)
{
    $glongDeg = PA_Macros\degrees_minutes_seconds_to_decimal_degrees($galLongDeg, $galLongMin, $galLongSec);
    $glatDeg = PA_Macros\degrees_minutes_seconds_to_decimal_degrees($galLatDeg, $galLatMin, $galLatSec);
    $glongRad = PA_Math\degrees_to_radians($glongDeg);
    $glatRad = PA_Math\degrees_to_radians($glatDeg);
    $sinDec = cos($glatRad) * cos(PA_Math\degrees_to_radians(27.4)) * sin($glongRad - PA_Math\degrees_to_radians(33.0)) + sin($glatRad) * sin(PA_Math\degrees_to_radians(27.4));
    $decRadians = asin($sinDec);
    $decDeg = PA_Macros\degrees($decRadians);
    $y = cos($glatRad) * cos($glongRad - PA_Math\degrees_to_radians(33.0));
    $x = sin($glatRad) * cos(PA_Math\degrees_to_radians(27.4)) - cos($glatRad) * sin(PA_Math\degrees_to_radians(27.4)) * sin($glongRad - PA_Math\degrees_to_radians(33.0));

    $raDeg1 = PA_Macros\degrees(atan2($y, $x)) + 192.25;
    $raDeg2 = $raDeg1 - 360 * floor($raDeg1 / 360);
    $raHours1 = PA_Macros\decimal_degrees_to_degree_hours($raDeg2);

    $raHours = PA_Macros\decimal_hours_hour($raHours1);
    $raMinutes = PA_Macros\decimal_hours_minute($raHours1);
    $raSeconds = PA_Macros\decimal_hours_second($raHours1);
    $decDegrees = PA_Macros\decimal_degrees_degrees($decDeg);
    $decMinutes = PA_Macros\decimal_degrees_minutes($decDeg);
    $decSeconds = PA_Macros\decimal_degrees_seconds($decDeg);

    return array($raHours, $raMinutes, $raSeconds, $decDegrees, $decMinutes, $decSeconds);
}

/**
 * Calculate the angle between two celestial objects
 */
function angle_between_two_objects($raLong1HourDeg, $raLong1Min, $raLong1Sec, $decLat1Deg, $decLat1Min, $decLat1Sec, $raLong2HourDeg, $raLong2Min, $raLong2Sec, $decLat2Deg, $decLat2Min, $decLat2Sec, PA_Types\AngleMeasure $hourOrDegree)
{
    $raLong1Decimal =
        ($hourOrDegree == PA_Types\AngleMeasure::Hours)
        ? PA_Macros\hours_minutes_seconds_to_decimal_hours($raLong1HourDeg, $raLong1Min, $raLong1Sec)
        : PA_Macros\degrees_minutes_seconds_to_decimal_degrees($raLong1HourDeg, $raLong1Min, $raLong1Sec);
    $raLong1Deg =
        ($hourOrDegree == PA_Types\AngleMeasure::Hours)
        ? PA_Macros\degree_hours_to_decimal_degrees($raLong1Decimal)
        : $raLong1Decimal;

    $raLong1Rad = PA_Math\degrees_to_radians($raLong1Deg);
    $decLat1Deg1 = PA_Macros\degrees_minutes_seconds_to_decimal_degrees($decLat1Deg, $decLat1Min, $decLat1Sec);
    $decLat1Rad = PA_Math\degrees_to_radians($decLat1Deg1);

    $raLong2Decimal =
        ($hourOrDegree == PA_Types\AngleMeasure::Hours)
        ? PA_Macros\hours_minutes_seconds_to_decimal_hours($raLong2HourDeg, $raLong2Min, $raLong2Sec)
        : PA_Macros\degrees_minutes_seconds_to_decimal_degrees($raLong2HourDeg, $raLong2Min, $raLong2Sec);
    $raLong2Deg = ($hourOrDegree == PA_Types\AngleMeasure::Hours)
        ? PA_Macros\degree_hours_to_decimal_degrees($raLong2Decimal)
        : $raLong2Decimal;
    $raLong2Rad = PA_Math\degrees_to_radians($raLong2Deg);
    $decLat2Deg1 = PA_Macros\degrees_minutes_seconds_to_decimal_degrees($decLat2Deg, $decLat2Min, $decLat2Sec);
    $decLat2Rad = PA_Math\degrees_to_radians($decLat2Deg1);

    $cosD = sin($decLat1Rad) * sin($decLat2Rad) + cos($decLat1Rad) * cos($decLat2Rad) * cos($raLong1Rad - $raLong2Rad);
    $dRad = acos($cosD);
    $dDeg = PA_Macros\degrees($dRad);

    $angleDeg = PA_Macros\decimal_degrees_degrees($dDeg);
    $angleMin = PA_Macros\decimal_degrees_minutes($dDeg);
    $angleSec = PA_Macros\decimal_degrees_seconds($dDeg);

    return array($angleDeg, $angleMin, $angleSec);
}

/**
 * Calculate rising and setting times for an object.
 */
function rising_and_setting($raHours, $raMinutes, $raSeconds, $decDeg, $decMin, $decSec, $gwDateDay, $gwDateMonth, $gwDateYear, $geogLongDeg, $geogLatDeg, $vertShiftDeg)
{
    $raHours1 = PA_Macros\hours_minutes_seconds_to_decimal_hours($raHours, $raMinutes, $raSeconds);
    $decRad = PA_Math\degrees_to_radians(PA_Macros\degrees_minutes_seconds_to_decimal_degrees($decDeg, $decMin, $decSec));
    $verticalDisplRadians = PA_Math\degrees_to_radians($vertShiftDeg);
    $geoLatRadians = PA_Math\degrees_to_radians($geogLatDeg);
    $cosH = - (sin($verticalDisplRadians) + sin($geoLatRadians) * sin($decRad)) / (cos($geoLatRadians) * cos($decRad));
    $hHours = PA_Macros\decimal_degrees_to_degree_hours(PA_Macros\degrees(acos($cosH)));
    $lstRiseHours = ($raHours1 - $hHours) - 24 * floor(($raHours1 - $hHours) / 24);
    $lstSetHours = ($raHours1 + $hHours) - 24 * floor(($raHours1 + $hHours) / 24);
    $aDeg = PA_Macros\degrees(acos((sin($decRad) + sin($verticalDisplRadians) * sin($geoLatRadians)) / (cos($verticalDisplRadians) * cos($geoLatRadians))));
    $azRiseDeg = $aDeg - 360 * floor($aDeg / 360);
    $azSetDeg = (360 - $aDeg) - 360 * floor((360 - $aDeg) / 360);
    $utRiseHours1 = PA_Macros\greenwich_sidereal_time_to_universal_time(PA_Macros\local_sidereal_time_to_greenwich_sidereal_time($lstRiseHours, 0, 0, $geogLongDeg), 0, 0, $gwDateDay, $gwDateMonth, $gwDateYear);
    $utSetHours1 = PA_Macros\greenwich_sidereal_time_to_universal_time(PA_Macros\local_sidereal_time_to_greenwich_sidereal_time($lstSetHours, 0, 0, $geogLongDeg), 0, 0, $gwDateDay, $gwDateMonth, $gwDateYear);
    $utRiseAdjustedHours = $utRiseHours1 + 0.008333;
    $utSetAdjustedHours = $utSetHours1 + 0.008333;

    $riseSetStatus = PA_Types\RiseSetStatus::OK;
    if ($cosH > 1)
        $riseSetStatus = PA_Types\RiseSetStatus::NeverRises;
    if ($cosH < -1)
        $riseSetStatus = PA_Types\RiseSetStatus::Circumpolar;

    $utRiseHour = ($riseSetStatus == PA_Types\RiseSetStatus::OK) ? PA_Macros\decimal_hours_hour($utRiseAdjustedHours) : 0;
    $utRiseMin = ($riseSetStatus == PA_Types\RiseSetStatus::OK) ? PA_Macros\decimal_hours_minute($utRiseAdjustedHours) : 0;
    $utSetHour = ($riseSetStatus == PA_Types\RiseSetStatus::OK) ? PA_Macros\decimal_hours_hour($utSetAdjustedHours) : 0;
    $utSetMin = ($riseSetStatus == PA_Types\RiseSetStatus::OK) ? PA_Macros\decimal_hours_minute($utSetAdjustedHours) : 0;
    $azRise = ($riseSetStatus == PA_Types\RiseSetStatus::OK) ? round($azRiseDeg, 2) : 0;
    $azSet = ($riseSetStatus == PA_Types\RiseSetStatus::OK) ? round($azSetDeg, 2) : 0;

    return array($riseSetStatus, $utRiseHour, $utRiseMin, $utSetHour, $utSetMin, $azRise, $azSet);
}

/**
 * Calculate precession (corrected coordinates between two epochs)
 */
function correct_for_precession($raHour, $raMinutes, $raSeconds, $decDeg, $decMinutes, $decSeconds, $epoch1Day, $epoch1Month, $epoch1Year, $epoch2Day, $epoch2Month, $epoch2Year)
{
    $ra1Rad = PA_Math\degrees_to_radians(PA_Macros\degree_hours_to_decimal_degrees(PA_Macros\hours_minutes_seconds_to_decimal_hours($raHour, $raMinutes, $raSeconds)));
    $dec1Rad = PA_Math\degrees_to_radians(PA_Macros\degrees_minutes_seconds_to_decimal_degrees($decDeg, $decMinutes, $decSeconds));
    $tCenturies = (PA_Macros\civil_date_to_julian_date($epoch1Day, $epoch1Month, $epoch1Year) - 2415020) / 36525;
    $mSec = 3.07234 + (0.00186 * $tCenturies);
    $nArcsec = 20.0468 - (0.0085 * $tCenturies);
    $nYears = (PA_Macros\civil_date_to_julian_date($epoch2Day, $epoch2Month, $epoch2Year) - PA_Macros\civil_date_to_julian_date($epoch1Day, $epoch1Month, $epoch1Year)) / 365.25;
    $s1Hours = (($mSec + ($nArcsec * sin($ra1Rad) * tan($dec1Rad) / 15)) * $nYears) / 3600;
    $ra2Hours = PA_Macros\hours_minutes_seconds_to_decimal_hours($raHour, $raMinutes, $raSeconds) + $s1Hours;
    $s2Deg = ($nArcsec * cos($ra1Rad) * $nYears) / 3600;
    $dec2Deg = PA_Macros\degrees_minutes_seconds_to_decimal_degrees($decDeg, $decMinutes, $decSeconds) + $s2Deg;

    $correctedRAHour = PA_Macros\decimal_hours_hour($ra2Hours);
    $correctedRAMinutes = PA_Macros\decimal_hours_minute($ra2Hours);
    $correctedRASeconds = PA_Macros\decimal_hours_second($ra2Hours);
    $correctedDecDeg = PA_Macros\decimal_degrees_degrees($dec2Deg);
    $correctedDecMinutes = PA_Macros\decimal_degrees_minutes($dec2Deg);
    $correctedDecSeconds = PA_Macros\decimal_degrees_seconds($dec2Deg);

    return array($correctedRAHour, $correctedRAMinutes, $correctedRASeconds, $correctedDecDeg, $correctedDecMinutes, $correctedDecSeconds);
}

/**
 * Calculate nutation for two values: ecliptic longitude and obliquity, for a Greenwich date.
 */
function nutation_in_ecliptic_longitude_and_obliquity($greenwichDay, $greenwichMonth, $greenwichYear)
{
    $jdDays = PA_Macros\civil_date_to_julian_date($greenwichDay, $greenwichMonth, $greenwichYear);
    $tCenturies = ($jdDays - 2415020) / 36525;
    $aDeg = 100.0021358 * $tCenturies;
    $l1Deg = 279.6967 + (0.000303 * $tCenturies * $tCenturies);
    $lDeg1 = $l1Deg + 360 * ($aDeg - floor($aDeg));
    $lDeg2 = $lDeg1 - 360 * floor($lDeg1 / 360);
    $lRad = PA_Math\degrees_to_radians($lDeg2);
    $bDeg = 5.372617 * $tCenturies;
    $nDeg1 = 259.1833 - 360 * ($bDeg - floor($bDeg));
    $nDeg2 = $nDeg1 - 360 * (floor($nDeg1 / 360));
    $nRad = PA_Math\degrees_to_radians($nDeg2);
    $nutInLongArcsec = -17.2 * sin($nRad) - 1.3 * sin(2 * $lRad);
    $nutInOblArcsec = 9.2 * cos($nRad) + 0.5 * cos(2 * $lRad);

    $nutInLongDeg = $nutInLongArcsec / 3600;
    $nutInOblDeg = $nutInOblArcsec / 3600;

    return array($nutInLongDeg, $nutInOblDeg);
}
