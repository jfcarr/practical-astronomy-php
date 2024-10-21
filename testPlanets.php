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

approximate_position_of_planet(0, 0, 0, false, 0, 22, 11, 2003, "Jupiter", 11, 11, 13.8, 6, 21, 25.1);
