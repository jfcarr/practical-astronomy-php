<?php

namespace PA\Test\Comet;

include_once 'lib/PAComet.php';
include_once 'lib/PAUtils.php';

use PA\Comet as PA_Comet;

use function PA\Utils\descriptive_assert;

function position_of_elliptical_comet($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $cometName, $expected_cometRAHour, $expected_cometRAMin, $expected_cometDecDeg, $expected_cometDecMin, $expected_cometDistEarth)
{
    $title = "Position of Elliptical Comet";

    list($cometRAHour, $cometRAMin, $cometDecDeg, $cometDecMin, $cometDistEarth) =
        PA_Comet\position_of_elliptical_comet($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $cometName);

    descriptive_assert("[{$title}] RA Hour", $cometRAHour, $expected_cometRAHour);
    descriptive_assert("[{$title}] RA Minutes", $cometRAMin, $expected_cometRAMin);
    descriptive_assert("[{$title}] Declination Degrees", $cometDecDeg, $expected_cometDecDeg);
    descriptive_assert("[{$title}] Declination Minutes", $cometDecMin, $expected_cometDecMin);
    descriptive_assert("[{$title}] Distance from Earth", $cometDistEarth, $expected_cometDistEarth);

    echo "[{$title}] PASSED\n";
}

function position_of_parabolic_comet($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $cometName, $expected_cometRAHour, $expected_cometRAMin, $expected_cometRASec, $expected_cometDecDeg, $expected_cometDecMin, $expected_cometDecSec, $expected_cometDistEarth)
{
    $title = "Position of Parabolic Comet";

    list($cometRAHour, $cometRAMin, $cometRASec, $cometDecDeg, $cometDecMin, $cometDecSec, $cometDistEarth) =
        PA_Comet\position_of_parabolic_comet($lctHour, $lctMin, $lctSec, $isDaylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear, $cometName);

    descriptive_assert("[{$title}] RA Hour", $cometRAHour, $expected_cometRAHour);
    descriptive_assert("[{$title}] RA Minutes", $cometRAMin, $expected_cometRAMin);
    descriptive_assert("[{$title}] RA Seconds", $cometRASec, $expected_cometRASec);
    descriptive_assert("[{$title}] Declination Degrees", $cometDecDeg, $expected_cometDecDeg);
    descriptive_assert("[{$title}] Declination Minutes", $cometDecMin, $expected_cometDecMin);
    descriptive_assert("[{$title}] Declination Seconds", $cometDecSec, $expected_cometDecSec);
    descriptive_assert("[{$title}] Distance from Earth", $cometDistEarth, $expected_cometDistEarth);

    echo "[{$title}] PASSED\n";
}

position_of_elliptical_comet(0, 0, 0, false, 0, 1, 1, 1984, "Halley", 6, 29, 10, 13, 8.13);

position_of_parabolic_comet(0, 0, 0, false, 0, 25, 12, 1977, "Kohler", 23, 17, 11.53, -33, 42, 26.42, 1.11);
