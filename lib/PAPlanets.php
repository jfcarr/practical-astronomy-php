<?php

namespace PA\Planets;

use PA\Data\Planets\PlanetDataManager;

use function PA\Macros\civil_date_to_julian_date;
use function PA\Macros\decimal_degrees_degrees;
use function PA\Macros\decimal_degrees_minutes;
use function PA\Macros\decimal_degrees_seconds;
use function PA\Macros\decimal_degrees_to_degree_hours;
use function PA\Macros\decimal_hours_hour;
use function PA\Macros\decimal_hours_minute;
use function PA\Macros\decimal_hours_second;
use function PA\Macros\ec_dec;
use function PA\Macros\ec_ra;
use function PA\Macros\local_civil_time_to_universal_time;
use function PA\Macros\local_civil_time_greenwich_day;
use function PA\Macros\local_civil_time_greenwich_month;
use function PA\Macros\local_civil_time_greenwich_year;
use function PA\Macros\planet_coordinates;
use function PA\Macros\sun_long;
use function PA\Macros\w_to_degrees;

include_once 'PAMacros.php';
include_once 'PATypes.php';
include_once 'data/Planet.php';

/**
 * Calculate approximate position of a planet.
 */
function approximate_position_of_planet($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $planetName)
{
        $planetDataManager = new PlanetDataManager();

        $daylightSaving = $isDaylightSaving ? 1 : 0;

        $planetData = $planetDataManager->GetPlanetRecord($planetName);

        $gdateDay = local_civil_time_greenwich_day($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
        $gdateMonth = local_civil_time_greenwich_month($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
        $gdateYear = local_civil_time_greenwich_year($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);

        $utHours = local_civil_time_to_universal_time($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
        $dDays = civil_date_to_julian_date($gdateDay + ($utHours / 24), $gdateMonth, $gdateYear) - civil_date_to_julian_date(0, 1, 2010);
        $npDeg1 = 360 * $dDays / (365.242191 * $planetData->tp_PeriodOrbit);
        $npDeg2 = $npDeg1 - 360 * floor($npDeg1 / 360);
        $mpDeg = $npDeg2 + $planetData->long_LongitudeEpoch - $planetData->peri_LongitudePerihelion;
        $lpDeg1 = $npDeg2 + (360 * $planetData->ecc_EccentricityOrbit * sin(deg2rad($mpDeg)) / pi()) + $planetData->long_LongitudeEpoch;
        $lpDeg2 = $lpDeg1 - 360 * floor($lpDeg1 / 360);
        $planetTrueAnomalyDeg = $lpDeg2 - $planetData->peri_LongitudePerihelion;
        $rAU = $planetData->axis_AxisOrbit * (1 - pow($planetData->ecc_EccentricityOrbit, 2)) / (1 + $planetData->ecc_EccentricityOrbit * cos(deg2rad($planetTrueAnomalyDeg)));

        $earthData = $planetDataManager->GetPlanetRecord("Earth");

        $neDeg1 = 360 * $dDays / (365.242191 * $earthData->tp_PeriodOrbit);
        $neDeg2 = $neDeg1 - 360 * floor($neDeg1 / 360);
        $meDeg = $neDeg2 + $earthData->long_LongitudeEpoch - $earthData->peri_LongitudePerihelion;
        $leDeg1 = $neDeg2 + $earthData->long_LongitudeEpoch + 360 * $earthData->ecc_EccentricityOrbit * sin(deg2rad($meDeg)) / pi();
        $leDeg2 = $leDeg1 - 360 * floor($leDeg1 / 360);
        $earthTrueAnomalyDeg = $leDeg2 - $earthData->peri_LongitudePerihelion;
        $rAU2 = $earthData->axis_AxisOrbit * (1 - pow($earthData->ecc_EccentricityOrbit, 2)) / (1 + $earthData->ecc_EccentricityOrbit * cos(deg2rad($earthTrueAnomalyDeg)));
        $lpNodeRad = deg2rad($lpDeg2 - $planetData->node_LongitudeAscendingNode);
        $psiRad = asin(sin($lpNodeRad) * sin(deg2rad($planetData->incl_OrbitalInclination)));
        $y = sin($lpNodeRad) * cos(deg2rad($planetData->incl_OrbitalInclination));
        $x = cos($lpNodeRad);
        $ldDeg =  w_to_degrees(atan2($y, $x)) + $planetData->node_LongitudeAscendingNode;
        $rdAU = $rAU * cos($psiRad);
        $leLdRad = deg2rad($leDeg2 - $ldDeg);
        $atan2Type1 = atan2(($rdAU * sin($leLdRad)), ($rAU2 - $rdAU * cos($leLdRad)));
        $atan2Type2 = atan2(($rAU2 * sin(-$leLdRad)), ($rdAU - $rAU2 * cos($leLdRad)));
        $aRad = ($rdAU < 1) ? $atan2Type1 : $atan2Type2;
        $lamdaDeg1 = ($rdAU < 1) ? 180 + $leDeg2 +  w_to_degrees($aRad) :  w_to_degrees($aRad) + $ldDeg;
        $lamdaDeg2 = $lamdaDeg1 - 360 * floor($lamdaDeg1 / 360);
        $betaDeg =  w_to_degrees(atan($rdAU * tan($psiRad) * sin(deg2rad($lamdaDeg2 - $ldDeg)) / ($rAU2 * sin(-$leLdRad))));
        $raHours = decimal_degrees_to_degree_hours(ec_ra($lamdaDeg2, 0, 0, $betaDeg, 0, 0, $gdateDay, $gdateMonth, $gdateYear));
        $decDeg =  ec_dec($lamdaDeg2, 0, 0, $betaDeg, 0, 0, $gdateDay, $gdateMonth, $gdateYear);

        $planetRAHour = decimal_hours_hour($raHours);
        $planetRAMin = decimal_hours_minute($raHours);
        $planetRASec = decimal_hours_second($raHours);
        $planetDecDeg = decimal_degrees_degrees($decDeg);
        $planetDecMin = decimal_degrees_minutes($decDeg);
        $planetDecSec = decimal_degrees_seconds($decDeg);

        return array($planetRAHour, $planetRAMin, $planetRASec, $planetDecDeg, $planetDecMin, $planetDecSec);
}

/**
 * Calculate precise position of a planet.
 */
function precise_position_of_planet($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $planetName)
{
        $daylightSaving = $isDaylightSaving ? 1 : 0;

        list($planetLongitude, $planetLatitude, $planetDistanceAU, $planetHLong1, $planetHLong2, $planetHLat, $planetRVect) =
                planet_coordinates($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $planetName);

        $planetRAHours = decimal_degrees_to_degree_hours(ec_ra($planetLongitude, 0, 0, $planetLatitude, 0, 0, $localDateDay, $localDateMonth, $localDateYear));
        $planetDecDeg1 = ec_dec($planetLongitude, 0, 0, $planetLatitude, 0, 0, $localDateDay, $localDateMonth, $localDateYear);

        $planetRAHour = decimal_hours_hour($planetRAHours);
        $planetRAMin = decimal_hours_minute($planetRAHours);
        $planetRASec = decimal_hours_second($planetRAHours);
        $planetDecDeg = decimal_degrees_degrees($planetDecDeg1);
        $planetDecMin = decimal_degrees_minutes($planetDecDeg1);
        $planetDecSec = decimal_degrees_seconds($planetDecDeg1);

        return array($planetRAHour, $planetRAMin, $planetRASec, $planetDecDeg, $planetDecMin, $planetDecSec);
}

/**
 * Calculate several visual aspects of a planet.
 */
function visual_aspects_of_a_planet($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $planetName)
{
        $daylightSaving = $isDaylightSaving ? 1 : 0;

        $greenwichDateDay = local_civil_time_greenwich_day($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
        $greenwichDateMonth = local_civil_time_greenwich_month($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
        $greenwichDateYear = local_civil_time_greenwich_year($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);

        list($planet_longitude, $planet_latitude, $planet_distance_au, $planet_h_long1, $planet_h_long2, $planet_h_lat, $planet_r_vec) = planet_coordinates($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $planetName);

        $planetRARad = deg2rad(ec_ra($planet_longitude, 0, 0, $planet_latitude, 0, 0, $localDateDay, $localDateMonth, $localDateYear));
        $planetDecRad = deg2rad(ec_dec($planet_longitude, 0, 0, $planet_latitude, 0, 0, $localDateDay, $localDateMonth, $localDateYear));

        $lightTravelTimeHours = $planet_distance_au * 0.1386;

        $planetDataManager = new PlanetDataManager();
        $planetData = $planetDataManager->GetPlanetRecord($planetName);

        $angularDiameterArcsec = $planetData->theta0_AngularDiameter / $planet_distance_au;
        $phase1 = 0.5 * (1.0 + cos(deg2rad(($planet_longitude - $planet_h_long1))));

        $sunEclLongDeg = sun_long($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
        $sunRARad = deg2rad(ec_ra($sunEclLongDeg, 0, 0, 0, 0, 0, $greenwichDateDay, $greenwichDateMonth, $greenwichDateYear));
        $sunDecRad = deg2rad(ec_dec($sunEclLongDeg, 0, 0, 0, 0, 0, $greenwichDateDay, $greenwichDateMonth, $greenwichDateYear));

        $y = cos($sunDecRad) * sin($sunRARad - $planetRARad);
        $x = cos($planetDecRad) * sin($sunDecRad) - sin($planetDecRad) * cos($sunDecRad) * cos($sunRARad - $planetRARad);
        $chiDeg = w_to_degrees(atan2($y, $x));
        $radiusVectorAU = $planet_r_vec;
        $approximateMagnitude1 = 5.0 * log10($radiusVectorAU * $planet_distance_au / sqrt($phase1)) + $planetData->v0_VisualMagnitude;

        $distanceAU =  round($planet_distance_au, 5);
        $angDiaArcsec = round($angularDiameterArcsec, 1);
        $phase = round($phase1, 2);
        $lightTimeHour = decimal_hours_hour($lightTravelTimeHours);
        $lightTimeMinutes = decimal_hours_minute($lightTravelTimeHours);
        $lightTimeSeconds = decimal_hours_second($lightTravelTimeHours);
        $posAngleBrightLimbDeg = round($chiDeg, 1);
        $approximateMagnitude = round($approximateMagnitude1, 1);

        return array($distanceAU, $angDiaArcsec, $phase, $lightTimeHour, $lightTimeMinutes, $lightTimeSeconds, $posAngleBrightLimbDeg, $approximateMagnitude);
}
