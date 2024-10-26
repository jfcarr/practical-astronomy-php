<?php

namespace PA\Comet;

use PA\Data\Comet\CometDataManager;

use function PA\Macros\civil_date_to_julian_date;
use function PA\Macros\decimal_degrees_degrees;
use function PA\Macros\decimal_degrees_minutes;
use function PA\Macros\decimal_degrees_to_degree_hours;
use function PA\Macros\decimal_hours_hour;
use function PA\Macros\decimal_hours_minute;
use function PA\Macros\ec_dec;
use function PA\Macros\ec_ra;
use function PA\Macros\local_civil_time_greenwich_day;
use function PA\Macros\local_civil_time_greenwich_month;
use function PA\Macros\local_civil_time_greenwich_year;
use function PA\Macros\sun_dist;
use function PA\Macros\sun_long;
use function PA\Macros\true_anomaly;
use function PA\Macros\w_to_degrees;

include_once 'PAMacros.php';
include_once 'data/Comet.php';

function position_of_elliptical_comet($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $cometName)
{
    $cometDataManager = new CometDataManager();

    $daylightSaving = $isDaylightSaving ? 1 : 0;

    $greenwichDateDay = local_civil_time_greenwich_day($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
    $greenwichDateMonth = local_civil_time_greenwich_month($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
    $greenwichDateYear = local_civil_time_greenwich_year($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);

    $cometInfo =  $cometDataManager->GetEllipticalRecord($cometName);

    $timeSinceEpochYears = (civil_date_to_julian_date($greenwichDateDay, $greenwichDateMonth, $greenwichDateYear) - civil_date_to_julian_date(0.0, 1, $greenwichDateYear)) / 365.242191 + $greenwichDateYear - $cometInfo->epoch_EpochOfPerihelion;
    $mcDeg = 360 * $timeSinceEpochYears / $cometInfo->period_PeriodOfOrbit;
    $mcRad = deg2rad($mcDeg - 360 * floor($mcDeg / 360));
    $eccentricity = $cometInfo->ecc_EccentricityOfOrbit;
    $trueAnomalyDeg = w_to_degrees(true_anomaly($mcRad, $eccentricity));
    $lcDeg = $trueAnomalyDeg + $cometInfo->peri_LongitudeOfPerihelion;
    $rAU = $cometInfo->axis_SemiMajorAxisOfOrbit * (1 - $eccentricity * $eccentricity) / (1 + $eccentricity * cos(deg2rad($trueAnomalyDeg)));
    $lcNodeRad = deg2rad($lcDeg - $cometInfo->node_LongitudeOfAscendingNode);
    $psiRad = asin(sin($lcNodeRad) * sin(deg2rad($cometInfo->incl_InclinationOfOrbit)));

    $y = sin($lcNodeRad) * cos(deg2rad($cometInfo->incl_InclinationOfOrbit));
    $x = cos($lcNodeRad);

    $ldDeg = w_to_degrees(atan2($y, $x)) + $cometInfo->node_LongitudeOfAscendingNode;
    $rdAU = $rAU * cos($psiRad);

    $earthLongitudeLeDeg = sun_long($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear) + 180.0;
    $earthRadiusVectorAU = sun_dist($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);

    $leLdRad = deg2rad($earthLongitudeLeDeg - $ldDeg);
    $aRad = ($rdAU < $earthRadiusVectorAU)
        ? atan2(($rdAU * sin($leLdRad)), ($earthRadiusVectorAU - $rdAU * cos($leLdRad)))
        : atan2(($earthRadiusVectorAU * sin(-$leLdRad)), ($rdAU - $earthRadiusVectorAU * cos($leLdRad)));

    $cometLongDeg1 = ($rdAU < $earthRadiusVectorAU)
        ? 180.0 + $earthLongitudeLeDeg + w_to_degrees($aRad)
        : w_to_degrees($aRad) + $ldDeg;
    $cometLongDeg = $cometLongDeg1 - 360 * floor($cometLongDeg1 / 360);
    $cometLatDeg = w_to_degrees(atan($rdAU * tan($psiRad) * sin(deg2rad($cometLongDeg1 - $ldDeg)) / ($earthRadiusVectorAU * sin(-$leLdRad))));
    $cometRAHours1 = decimal_degrees_to_degree_hours(ec_ra($cometLongDeg, 0, 0, $cometLatDeg, 0, 0, $greenwichDateDay, $greenwichDateMonth, $greenwichDateYear));
    $cometDecDeg1 = ec_dec($cometLongDeg, 0, 0, $cometLatDeg, 0, 0, $greenwichDateDay, $greenwichDateMonth, $greenwichDateYear);
    $cometDistanceAU = sqrt(pow($earthRadiusVectorAU, 2) + pow($rAU, 2) - 2.0 * $earthRadiusVectorAU * $rAU * cos(deg2rad($lcDeg - $earthLongitudeLeDeg)) * cos($psiRad));

    $cometRAHour = decimal_hours_hour($cometRAHours1 + 0.008333);
    $cometRAMin = decimal_hours_minute($cometRAHours1 + 0.008333);
    $cometDecDeg = decimal_degrees_degrees($cometDecDeg1 + 0.008333);
    $cometDecMin = decimal_degrees_minutes($cometDecDeg1 + 0.008333);
    $cometDistEarth = round($cometDistanceAU, 2);

    return array($cometRAHour, $cometRAMin, $cometDecDeg, $cometDecMin, $cometDistEarth);
}
