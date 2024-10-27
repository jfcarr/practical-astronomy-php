<?php

namespace PA\Moon;

use PA\Types\AccuracyLevel;

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
use function PA\Macros\local_civil_time_greenwich_day;
use function PA\Macros\local_civil_time_greenwich_month;
use function PA\Macros\local_civil_time_greenwich_year;
use function PA\Macros\local_civil_time_to_universal_time;
use function PA\Macros\moon_long_lat_hp;
use function PA\Macros\moon_phase_ma;
use function PA\Macros\nutat_long;
use function PA\Macros\sun_long;
use function PA\Macros\sun_mean_anomaly;
use function PA\Macros\unwind_deg;
use function PA\Macros\w_to_degrees;

include_once 'PAMacros.php';
include_once 'PATypes.php';

/** Calculate approximate position of the Moon. */
function approximate_position_of_moon($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear)
{
    $daylightSaving = $isDaylightSaving ? 1 : 0;

    $l0 = 91.9293359879052;
    $p0 = 130.143076320618;
    $n0 = 291.682546643194;
    $i = 5.145396;

    $gdateDay = local_civil_time_greenwich_day($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
    $gdateMonth = local_civil_time_greenwich_month($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
    $gdateYear = local_civil_time_greenwich_year($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);

    $utHours = local_civil_time_to_universal_time($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
    $dDays = civil_date_to_julian_date($gdateDay, $gdateMonth, $gdateYear) - civil_date_to_julian_date(0.0, 1, 2010) + $utHours / 24;
    $sunLongDeg = sun_long($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
    $sunMeanAnomalyRad = sun_mean_anomaly($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
    $lmDeg = unwind_deg(13.1763966 * $dDays + $l0);
    $mmDeg = unwind_deg($lmDeg - 0.1114041 * $dDays - $p0);
    $nDeg = unwind_deg($n0 - (0.0529539 * $dDays));
    $evDeg = 1.2739 * sin(deg2rad(2.0 * ($lmDeg - $sunLongDeg) - $mmDeg));
    $aeDeg = 0.1858 * sin($sunMeanAnomalyRad);
    $a3Deg = 0.37 * sin($sunMeanAnomalyRad);
    $mmdDeg = $mmDeg + $evDeg - $aeDeg - $a3Deg;
    $ecDeg = 6.2886 * sin(deg2rad($mmdDeg));
    $a4Deg = 0.214 * sin(2.0 * deg2rad($mmdDeg));
    $ldDeg = $lmDeg + $evDeg + $ecDeg - $aeDeg + $a4Deg;
    $vDeg = 0.6583 * sin(2.0 * deg2rad($ldDeg - $sunLongDeg));
    $lddDeg = $ldDeg + $vDeg;
    $ndDeg = $nDeg - 0.16 * sin($sunMeanAnomalyRad);
    $y = sin(deg2rad($lddDeg - $ndDeg)) * cos(deg2rad($i));
    $x = cos(deg2rad($lddDeg - $ndDeg));

    $moonLongDeg = unwind_deg(w_to_degrees(atan2($y, $x)) + $ndDeg);
    $moonLatDeg = w_to_degrees(asin(sin(deg2rad($lddDeg - $ndDeg)) * sin(deg2rad($i))));
    $moonRAHours1 = decimal_degrees_to_degree_hours(ec_ra($moonLongDeg, 0, 0, $moonLatDeg, 0, 0, $gdateDay, $gdateMonth, $gdateYear));
    $moonDecDeg1 = ec_dec($moonLongDeg, 0, 0, $moonLatDeg, 0, 0, $gdateDay, $gdateMonth, $gdateYear);

    $moonRAHour = decimal_hours_hour($moonRAHours1);
    $moonRAMin = decimal_hours_minute($moonRAHours1);
    $moonRASec = decimal_hours_second($moonRAHours1);
    $moonDecDeg = decimal_degrees_degrees($moonDecDeg1);
    $moonDecMin = decimal_degrees_minutes($moonDecDeg1);
    $moonDecSec = decimal_degrees_seconds($moonDecDeg1);

    return array($moonRAHour, $moonRAMin, $moonRASec, $moonDecDeg, $moonDecMin, $moonDecSec);
}

/** Calculate precise position of the Moon. */
function precise_position_of_moon($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear)
{
    $daylightSaving = $isDaylightSaving ? 1 : 0;

    $gdateDay = local_civil_time_greenwich_day($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
    $gdateMonth = local_civil_time_greenwich_month($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
    $gdateYear = local_civil_time_greenwich_year($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);

    list($ml_moonLongDeg, $ml_moonLatDeg, $ml_moonHorPara) =
        moon_long_lat_hp($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);

    $nutationInLongitudeDeg = nutat_long($gdateDay, $gdateMonth, $gdateYear);
    $correctedLongDeg = $ml_moonLongDeg + $nutationInLongitudeDeg;
    $earthMoonDistanceKM = 6378.14 / sin(deg2rad($ml_moonHorPara));
    $moonRAHours1 = decimal_degrees_to_degree_hours(ec_ra($correctedLongDeg, 0, 0, $ml_moonLatDeg, 0, 0, $gdateDay, $gdateMonth, $gdateYear));
    $moonDecDeg1 = ec_dec($correctedLongDeg, 0, 0, $ml_moonLatDeg, 0, 0, $gdateDay, $gdateMonth, $gdateYear);

    $moonRAHour = decimal_hours_hour($moonRAHours1);
    $moonRAMin = decimal_hours_minute($moonRAHours1);
    $moonRASec = decimal_hours_second($moonRAHours1);
    $moonDecDeg = decimal_degrees_degrees($moonDecDeg1);
    $moonDecMin = decimal_degrees_minutes($moonDecDeg1);
    $moonDecSec = decimal_degrees_seconds($moonDecDeg1);
    $earthMoonDistKM = round($earthMoonDistanceKM, 0);
    $moonHorParallaxDeg = round($ml_moonHorPara, 6);

    return array($moonRAHour, $moonRAMin, $moonRASec, $moonDecDeg, $moonDecMin, $moonDecSec, $earthMoonDistKM, $moonHorParallaxDeg);
}

/** Calculate Moon phase and position angle of bright limb. */
function moon_phase($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $accuracyLevel)
{
    $daylightSaving = $isDaylightSaving ? 1 : 0;

    $gdateDay = local_civil_time_greenwich_day($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
    $gdateMonth = local_civil_time_greenwich_month($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
    $gdateYear = local_civil_time_greenwich_year($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);

    $sunLongDeg = sun_long($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
    list($moonLongDeg, $moonLatDeg, $moonHorPara) = moon_long_lat_hp($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
    $dRad = deg2rad($moonLongDeg - $sunLongDeg);

    $moonPhase1 = ($accuracyLevel == AccuracyLevel::Precise)
        ? moon_phase_ma($lctHour, $lctMin, $lctSec, $daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear)
        : (1.0 - cos($dRad)) / 2.0;

    $sunRARad = deg2rad(ec_ra($sunLongDeg, 0, 0, 0, 0, 0, $gdateDay, $gdateMonth, $gdateYear));
    $moonRARad = deg2rad(ec_ra($moonLongDeg, 0, 0, $moonLatDeg, 0, 0, $gdateDay, $gdateMonth, $gdateYear));
    $sunDecRad = deg2rad(ec_dec($sunLongDeg, 0, 0, 0, 0, 0, $gdateDay, $gdateMonth, $gdateYear));
    $moonDecRad = deg2rad(ec_dec($moonLongDeg, 0, 0, $moonLatDeg, 0, 0, $gdateDay, $gdateMonth, $gdateYear));

    $y = cos($sunDecRad) * sin($sunRARad - $moonRARad);
    $x = cos($moonDecRad) * sin($sunDecRad) - sin($moonDecRad) * cos($sunDecRad) * cos($sunRARad - $moonRARad);

    $chiDeg = w_to_degrees(atan2($y, $x));

    $moonPhase = round($moonPhase1, 2);
    $paBrightLimbDeg = round($chiDeg, 2);

    return array($moonPhase, $paBrightLimbDeg);
}
