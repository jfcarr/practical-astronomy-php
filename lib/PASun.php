<?php

namespace PA\Sun;

include_once 'PAMacros.php';
include_once 'PAMathExtensions.php';
include_once 'PATypes.php';

use PA\Macros as PA_Macros;
use PA\MathExtensions as PA_Math;
use PA\Types as PA_Types;
use PA\Types\RiseSetStatus;

/**
 * Calculate approximate position of the sun for a local date and time.
 */
function approximate_position_of_sun($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection)
{
    $daylightSaving = ($isDaylightSaving == true) ? 1 : 0;

    $greenwichDateDay = PA_Macros\local_civil_time_greenwich_day($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $greenwichDateMonth = PA_Macros\local_civil_time_greenwich_month($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $greenwichDateYear = PA_Macros\local_civil_time_greenwich_year($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $utHours = PA_Macros\local_civil_time_to_universal_time($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $utDays = $utHours / 24;
    $jdDays = PA_Macros\civil_date_to_julian_date($greenwichDateDay, $greenwichDateMonth, $greenwichDateYear) + $utDays;
    $dDays = $jdDays - PA_Macros\civil_date_to_julian_date(0, 1, 2010);
    $nDeg = 360 * $dDays / 365.242191;
    $mDeg1 = $nDeg + PA_Macros\sun_e_long(0, 1, 2010) - PA_Macros\sun_peri(0, 1, 2010);
    $mDeg2 = $mDeg1 - 360 * floor($mDeg1 / 360);
    $eCDeg = 360 * PA_Macros\sun_ecc(0, 1, 2010) * sin(PA_Math\degrees_to_radians($mDeg2)) / pi();
    $lSDeg1 = $nDeg + $eCDeg + PA_Macros\sun_e_long(0, 1, 2010);
    $lSDeg2 = $lSDeg1 - 360 * floor($lSDeg1 / 360);
    $raDeg = PA_Macros\ec_ra($lSDeg2, 0, 0, 0, 0, 0, $greenwichDateDay, $greenwichDateMonth, $greenwichDateYear);
    $raHours = PA_Macros\decimal_degrees_to_degree_hours($raDeg);
    $decDeg = PA_Macros\ec_dec($lSDeg2, 0, 0, 0, 0, 0, $greenwichDateDay, $greenwichDateMonth, $greenwichDateYear);

    $sunRAHour = PA_Macros\decimal_hours_hour($raHours);
    $sunRAMin = PA_Macros\decimal_hours_minute($raHours);
    $sunRASec = PA_Macros\decimal_hours_second($raHours);
    $sunDecDeg = PA_Macros\decimal_degrees_degrees($decDeg);
    $sunDecMin = PA_Macros\decimal_degrees_minutes($decDeg);
    $sunDecSec = PA_Macros\decimal_degrees_seconds($decDeg);

    return array($sunRAHour, $sunRAMin, $sunRASec, $sunDecDeg, $sunDecMin, $sunDecSec);
}

/**
 * Calculate precise position of the sun for a local date and time.
 */
function precise_position_of_sun($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection)
{
    $daylightSaving = ($isDaylightSaving == true) ? 1 : 0;

    $gDay = PA_Macros\local_civil_time_greenwich_day($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $gMonth = PA_Macros\local_civil_time_greenwich_month($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $gYear = PA_Macros\local_civil_time_greenwich_year($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $sunEclipticLongitudeDeg = PA_Macros\sun_long($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $raDeg = PA_Macros\ec_ra($sunEclipticLongitudeDeg, 0, 0, 0, 0, 0, $gDay, $gMonth, $gYear);
    $raHours = PA_Macros\decimal_degrees_to_degree_hours($raDeg);
    $decDeg = PA_Macros\ec_dec($sunEclipticLongitudeDeg, 0, 0, 0, 0, 0, $gDay, $gMonth, $gYear);

    $sunRAHour = PA_Macros\decimal_hours_hour($raHours);
    $sunRAMin = PA_Macros\decimal_hours_minute($raHours);
    $sunRASec = PA_Macros\decimal_hours_second($raHours);
    $sunDecDeg = PA_Macros\decimal_degrees_degrees($decDeg);
    $sunDecMin = PA_Macros\decimal_degrees_minutes($decDeg);
    $sunDecSec = PA_Macros\decimal_degrees_seconds($decDeg);

    return array($sunRAHour, $sunRAMin, $sunRASec, $sunDecDeg, $sunDecMin, $sunDecSec);
}

/**
 * Calculate distance to the Sun (in km), and angular size.
 */
function sun_distance_and_angular_size($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection)
{
    $daylightSaving = ($isDaylightSaving) ? 1 : 0;

    $gDay = PA_Macros\local_civil_time_greenwich_day($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $gMonth = PA_Macros\local_civil_time_greenwich_month($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $gYear = PA_Macros\local_civil_time_greenwich_year($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $trueAnomalyDeg = PA_Macros\sun_true_anomaly($lctHours, $lctMinutes, $lctSeconds, $daylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear);
    $trueAnomalyRad = PA_Math\degrees_to_radians($trueAnomalyDeg);
    $eccentricity = PA_Macros\sun_ecc($gDay, $gMonth, $gYear);
    $f = (1 + $eccentricity * cos($trueAnomalyRad)) / (1 - $eccentricity * $eccentricity);
    $rKm = 149598500 / $f;
    $thetaDeg = $f * 0.533128;

    $sunDistKm = round($rKm, 0);
    $sunAngSizeDeg = PA_Macros\decimal_degrees_degrees($thetaDeg);
    $sunAngSizeMin = PA_Macros\decimal_degrees_minutes($thetaDeg);
    $sunAngSizeSec = PA_Macros\decimal_degrees_seconds($thetaDeg);

    return array($sunDistKm, $sunAngSizeDeg, $sunAngSizeMin, $sunAngSizeSec);
}

/**
 * Calculate local sunrise and sunset.
 */
function sunrise_and_sunset($localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $geographicalLongDeg, $geographicalLatDeg)
{
    $daylightSaving = ($isDaylightSaving) ? 1 : 0;

    $localSunriseHours = PA_Macros\sunrise_lct($localDay, $localMonth, $localYear, $daylightSaving, $zoneCorrection, $geographicalLongDeg, $geographicalLatDeg);
    $localSunsetHours = PA_Macros\sunset_lct($localDay, $localMonth, $localYear, $daylightSaving, $zoneCorrection, $geographicalLongDeg, $geographicalLatDeg);

    $sunRiseSetStatus = PA_Macros\e_sun_rs($localDay, $localMonth, $localYear, $daylightSaving, $zoneCorrection, $geographicalLongDeg, $geographicalLatDeg);

    $adjustedSunriseHours = $localSunriseHours + 0.008333;
    $adjustedSunsetHours = $localSunsetHours + 0.008333;

    $azimuthOfSunriseDeg1 = PA_Macros\sunrise_az($localDay, $localMonth, $localYear, $daylightSaving, $zoneCorrection, $geographicalLongDeg, $geographicalLatDeg);
    $azimuthOfSunsetDeg1 = PA_Macros\sunset_az($localDay, $localMonth, $localYear, $daylightSaving, $zoneCorrection, $geographicalLongDeg, $geographicalLatDeg);

    $localSunriseHour = ($sunRiseSetStatus == RiseSetStatus::OK) ? PA_Macros\decimal_hours_hour($adjustedSunriseHours) : 0;
    $localSunriseMinute = ($sunRiseSetStatus == RiseSetStatus::OK) ? PA_Macros\decimal_hours_minute($adjustedSunriseHours) : 0;

    $localSunsetHour = ($sunRiseSetStatus == RiseSetStatus::OK) ? PA_Macros\decimal_hours_hour($adjustedSunsetHours) : 0;
    $localSunsetMinute = ($sunRiseSetStatus == RiseSetStatus::OK) ? PA_Macros\decimal_hours_minute($adjustedSunsetHours) : 0;

    $azimuthOfSunriseDeg = ($sunRiseSetStatus == RiseSetStatus::OK) ? round($azimuthOfSunriseDeg1, 2) : 0;
    $azimuthOfSunsetDeg = ($sunRiseSetStatus == RiseSetStatus::OK) ? round($azimuthOfSunsetDeg1, 2) : 0;

    $status = $sunRiseSetStatus;

    return array($localSunriseHour, $localSunriseMinute, $localSunsetHour, $localSunsetMinute, $azimuthOfSunriseDeg, $azimuthOfSunsetDeg, $status);
}
