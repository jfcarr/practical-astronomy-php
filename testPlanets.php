<?php

namespace PA\Test\Planets;

include_once 'lib/PAPlanets.php';
include_once 'lib/PAUtils.php';

use PA\Planets as PA_Planets;

use function PA\Utils\descriptive_assert;

function approximate_position_of_planet($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $planetName, $expected_planetRAHour, $expected_planetRAMin, $expected_planetRASec, $expected_planetDecDeg, $expected_planetDecMin, $expected_planetDecSec)
{
    $title = "Approximate Position of Planet";

    list($planetRAHour, $planetRAMin, $planetRASec, $planetDecDeg, $planetDecMin, $planetDecSec) =
        PA_Planets\approximate_position_of_planet($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $planetName);

    descriptive_assert("[{$title}] RA Hour", $planetRAHour, $expected_planetRAHour);
    descriptive_assert("[{$title}] RA Minutes", $planetRAMin, $expected_planetRAMin);
    descriptive_assert("[{$title}] RA Seconds", $planetRASec, $expected_planetRASec);
    descriptive_assert("[{$title}] Declination Degrees", $planetDecDeg, $expected_planetDecDeg);
    descriptive_assert("[{$title}] Declination Minutes", $planetDecMin, $expected_planetDecMin);
    descriptive_assert("[{$title}] Declination Seconds", $planetDecSec, $expected_planetDecSec);

    echo "[{$title}] PASSED\n";
}

function precise_position_of_planet($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $planetName, $expected_planetRAHour, $expected_planetRAMin, $expected_planetRASec, $expected_planetDecDeg, $expected_planetDecMin, $expected_planetDecSec)
{
    $title = "Precise Position of Planet";

    list($planetRAHour, $planetRAMin, $planetRASec, $planetDecDeg, $planetDecMin, $planetDecSec) =
        PA_Planets\precise_position_of_planet($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $planetName);

    descriptive_assert("[{$title}] RA Hour", $planetRAHour, $expected_planetRAHour);
    descriptive_assert("[{$title}] RA Minutes", $planetRAMin, $expected_planetRAMin);
    descriptive_assert("[{$title}] RA Seconds", $planetRASec, $expected_planetRASec);
    descriptive_assert("[{$title}] Declination Degrees", $planetDecDeg, $expected_planetDecDeg);
    descriptive_assert("[{$title}] Declination Minutes", $planetDecMin, $expected_planetDecMin);
    descriptive_assert("[{$title}] Declination Seconds", $planetDecSec, $expected_planetDecSec);

    echo "[{$title}] PASSED\n";
}

function visual_aspects_of_a_planet($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $planetName, $expected_distanceAU, $expected_angDiaArcsec, $expected_phase, $expected_lightTimeHour, $expected_lightTimeMinutes, $expected_lightTimeSeconds, $expected_posAngleBrightLimbDeg, $expected_approximateMagnitude)
{
    $title = "Visual Aspects of a Planet";

    list($distanceAU, $angDiaArcsec, $phase, $lightTimeHour, $lightTimeMinutes, $lightTimeSeconds, $posAngleBrightLimbDeg, $approximateMagnitude) =
        PA_Planets\visual_aspects_of_a_planet($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $planetName);

    descriptive_assert("[{$title}] Distance AU", $distanceAU, $expected_distanceAU);
    descriptive_assert("[{$title}] Angular Diameter arcseconds", $angDiaArcsec, $expected_angDiaArcsec);
    descriptive_assert("[{$title}] Phase", $phase, $expected_phase);
    descriptive_assert("[{$title}] Light Time hours", $lightTimeHour, $expected_lightTimeHour);
    descriptive_assert("[{$title}] Light Time minutes", $lightTimeMinutes, $expected_lightTimeMinutes);
    descriptive_assert("[{$title}] Light Time seconds", $lightTimeSeconds, $expected_lightTimeSeconds);
    descriptive_assert("[{$title}] Position Angle of Bright Limb degrees", $posAngleBrightLimbDeg, $expected_posAngleBrightLimbDeg);
    descriptive_assert("[{$title}] Approximate Magnitude", $approximateMagnitude, $expected_approximateMagnitude);

    echo "[{$title}] PASSED\n";
}

approximate_position_of_planet(0, 0, 0, false, 0, 22, 11, 2003, "Jupiter", 11, 11, 13.8, 6, 21, 25.1);

precise_position_of_planet(0, 0, 0, false, 0, 22, 11, 2003, "Jupiter", 11, 10, 30.99, 6, 25, 49.46);

visual_aspects_of_a_planet(0, 0, 0, false, 0, 22, 11, 2003, "Jupiter", 5.59829, 35.1, 0.99, 0, 46, 33.32, 113.2, -2.0);
