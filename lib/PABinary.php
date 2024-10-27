<?php

namespace PA\Binary;

use PA\Data\Binary\BinaryDataManager;

use function PA\Macros\civil_date_to_julian_date;
use function PA\Macros\eccentric_anomaly;
use function PA\Macros\true_anomaly;
use function PA\Macros\w_to_degrees;

include_once 'PAMacros.php';
include_once 'data/Binary.php';

/**
 * Calculate orbital data for binary star.
 */
function binary_star_orbit($greenwichDateDay, $greenwichDateMonth, $greenwichDateYear, $binaryName)
{
    $binaryDataManager = new BinaryDataManager();

    $binaryData =  $binaryDataManager->GetBinaryRecord($binaryName);

    $yYears = $greenwichDateYear + (civil_date_to_julian_date($greenwichDateDay, $greenwichDateMonth, $greenwichDateYear) - civil_date_to_julian_date(0, 1, $greenwichDateYear)) / 365.242191 - $binaryData->epochPeri;
    $mDeg = 360 * $yYears / $binaryData->period;
    $mRad = deg2rad($mDeg - 360 * floor($mDeg / 360));
    $eccentricity = $binaryData->ecc;
    $trueAnomalyRad = true_anomaly($mRad, $eccentricity);
    $rArcsec = (1 - $eccentricity * cos(eccentric_anomaly($mRad, $eccentricity))) * $binaryData->axis;
    $taPeriRad = $trueAnomalyRad + deg2rad($binaryData->longPeri);

    $y = sin($taPeriRad) * cos(deg2rad($binaryData->incl));
    $x = cos($taPeriRad);
    $aDeg = w_to_degrees(atan2($y, $x));
    $thetaDeg1 = $aDeg + $binaryData->paNode;
    $thetaDeg2 = $thetaDeg1 - 360 * floor($thetaDeg1 / 360);
    $rhoArcsec = $rArcsec * cos($taPeriRad) / cos(deg2rad($thetaDeg2 - $binaryData->paNode));

    $positionAngleDeg = round($thetaDeg2, 1);
    $separationArcsec = round($rhoArcsec, 2);

    return array($positionAngleDeg, $separationArcsec);
}
