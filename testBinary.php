<?php

namespace PA\Test\Binary;

include_once 'lib/PABinary.php';
include_once 'lib/PAUtils.php';

use PA\Binary as PA_Binary;

use function PA\Utils\descriptive_assert;


function binary_star_orbit($greenwichDateDay, $greenwichDateMonth, $greenwichDateYear, $binaryName, $expected_positionAngleDeg, $expected_separationArcsec)
{
    $title = "Binary Star Orbit";

    list($positionAngleDeg, $separationArcsec) =
        PA_Binary\binary_star_orbit($greenwichDateDay, $greenwichDateMonth, $greenwichDateYear, $binaryName, $expected_positionAngleDeg, $expected_separationArcsec);

    descriptive_assert("[{$title}] Position Angle degrees", $positionAngleDeg, $expected_positionAngleDeg);
    descriptive_assert("[{$title}] Separation arcsecs", $separationArcsec, $expected_separationArcsec);

    echo "[{$title}] PASSED\n";
}

binary_star_orbit(1, 1, 1980, "eta-Cor", 318.5, 0.41);
