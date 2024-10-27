<?php

namespace PA\Test\Moon;

include_once 'lib/PAMoon.php';
include_once 'lib/PAUtils.php';

use PA\Moon as PA_Moon;

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

approximate_position_of_moon(0, 0, 0, false, 0, 1, 9, 2003, 14, 12, 42.31, -11, 31, 38.27);
