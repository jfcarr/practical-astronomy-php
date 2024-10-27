<?php

namespace PA\Test\Moon;

include_once 'lib/PAMoon.php';
include_once 'lib/PATypes.php';
include_once 'lib/PAUtils.php';

use PA\Moon as PA_Moon;
use PA\Types\AccuracyLevel;

use function PA\Utils\descriptive_assert;

function approximate_position_of_moon($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $expected_moonRAHour, $expected_moonRAMin, $expected_moonRASec, $expected_moonDecDeg, $expected_moonDecMin, $expected_moonDecSec)
{
    $title = "Approximate Position of Moon";

    list($moonRAHour, $moonRAMin, $moonRASec, $moonDecDeg, $moonDecMin, $moonDecSec) =
        PA_Moon\approximate_position_of_moon($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);

    descriptive_assert("[{$title}] RA Hour", $moonRAHour, $expected_moonRAHour);
    descriptive_assert("[{$title}] RA Minutes", $moonRAMin, $expected_moonRAMin);
    descriptive_assert("[{$title}] RA Seconds", $moonRASec, $expected_moonRASec);
    descriptive_assert("[{$title}] Declination Degrees", $moonDecDeg, $expected_moonDecDeg);
    descriptive_assert("[{$title}] Declination Minutes", $moonDecMin, $expected_moonDecMin);
    descriptive_assert("[{$title}] Declination Seconds", $moonDecSec, $expected_moonDecSec);

    echo "[{$title}] PASSED\n";
}

function precise_position_of_moon($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $expected_moonRAHour, $expected_moonRAMin, $expected_moonRASec, $expected_moonDecDeg, $expected_moonDecMin, $expected_moonDecSec, $expected_earthMoonDistKM, $expected_moonHorParallaxDeg)
{
    $title = "Precise Position of Moon";

    list($moonRAHour, $moonRAMin, $moonRASec, $moonDecDeg, $moonDecMin, $moonDecSec, $earthMoonDistKM, $moonHorParallaxDeg) =
        PA_Moon\precise_position_of_moon($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);

    descriptive_assert("[{$title}] RA Hour", $moonRAHour, $expected_moonRAHour);
    descriptive_assert("[{$title}] RA Minutes", $moonRAMin, $expected_moonRAMin);
    descriptive_assert("[{$title}] RA Seconds", $moonRASec, $expected_moonRASec);
    descriptive_assert("[{$title}] Declination Degrees", $moonDecDeg, $expected_moonDecDeg);
    descriptive_assert("[{$title}] Declination Minutes", $moonDecMin, $expected_moonDecMin);
    descriptive_assert("[{$title}] Declination Seconds", $moonDecSec, $expected_moonDecSec);
    descriptive_assert("[{$title}] Earth-Moon Distance", $earthMoonDistKM, $expected_earthMoonDistKM);
    descriptive_assert("[{$title}] Horizontal Parallax", $moonHorParallaxDeg, $expected_moonHorParallaxDeg);

    echo "[{$title}] PASSED\n";
}

function moon_phase($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $accuracyLevel, $expected_moonPhase, $expected_paBrightLimbDeg)
{
    $title = "Moon Phase";

    list($moonPhase, $paBrightLimbDeg) =
        PA_Moon\moon_phase($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $accuracyLevel);

    descriptive_assert("[{$title}] Moon Phase", $moonPhase, $expected_moonPhase);
    descriptive_assert("[{$title}] Bright Limb degrees", $paBrightLimbDeg, $expected_paBrightLimbDeg);

    echo "[{$title}] PASSED\n";
}

function times_of_new_moon_and_full_moon($isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $expected_nmLocalTimeHour, $expected_nmLocalTimeMin, $expected_nmLocalDateDay, $expected_nmLocalDateMonth, $expected_nmLocalDateYear, $expected_fmLocalTimeHour, $expected_fmLocalTimeMin, $expected_fmLocalDateDay, $expected_fmLocalDateMonth, $expected_fmLocalDateYear)
{
    $title = "Times of New Moon and Full Moon";

    list($nmLocalTimeHour, $nmLocalTimeMin, $nmLocalDateDay, $nmLocalDateMonth, $nmLocalDateYear, $fmLocalTimeHour, $fmLocalTimeMin, $fmLocalDateDay, $fmLocalDateMonth, $fmLocalDateYear) =
        PA_Moon\times_of_new_moon_and_full_moon($isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);

    descriptive_assert("[{$title}] New Moon - Local Time - Hours", $nmLocalTimeHour, $expected_nmLocalTimeHour);
    descriptive_assert("[{$title}] New Moon - Local Time - Minutes", $nmLocalTimeMin, $expected_nmLocalTimeMin);
    descriptive_assert("[{$title}] New Moon - Local Date - Day", $nmLocalDateDay, $expected_nmLocalDateDay);
    descriptive_assert("[{$title}] New Moon - Local Date - Month", $nmLocalDateMonth, $expected_nmLocalDateMonth);
    descriptive_assert("[{$title}] New Moon - Local Date - Year", $nmLocalDateYear, $expected_nmLocalDateYear);
    descriptive_assert("[{$title}] Full Moon - Local Time - Hours", $fmLocalTimeHour, $expected_fmLocalTimeHour);
    descriptive_assert("[{$title}] Full Moon - Local Time - Minutes", $fmLocalTimeMin, $expected_fmLocalTimeMin);
    descriptive_assert("[{$title}] Full Moon - Local Date - Day", $fmLocalDateDay, $expected_fmLocalDateDay);
    descriptive_assert("[{$title}] Full Moon - Local Date - Month", $fmLocalDateMonth, $expected_fmLocalDateMonth);
    descriptive_assert("[{$title}] Full Moon - Local Date - Year", $fmLocalDateYear, $expected_fmLocalDateYear);

    echo "[{$title}] PASSED\n";
}

approximate_position_of_moon(0, 0, 0, false, 0, 1, 9, 2003, 14, 12, 42.31, -11, 31, 38.27);

precise_position_of_moon(0, 0, 0, false, 0, 1, 9, 2003, 14, 12, 10.21, -11, 34, 57.83, 367964, 0.993191);

moon_phase(0, 0, 0, false, 0, 1, 9, 2003, AccuracyLevel::Approximate, 0.22, -71.58);

times_of_new_moon_and_full_moon(false, 0, 1, 9, 2003, 17, 27, 27, 8, 2003, 16, 36, 10, 9, 2003);
