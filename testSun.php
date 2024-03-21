<?php

namespace PA\Test\Sun;

include_once 'lib/PASun.php';

use PA\Sun as PA_Sun;

function approximate_position_of_sun($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $expectedSunRAHour, $expectedSunRAMin, $expectedSunRASec, $expectedSunDecDeg, $expectedSunDecMin, $expectedSunDecSec)
{
    list($sunRAHour, $sunRAMin, $sunRASec, $sunDecDeg, $sunDecMin, $sunDecSec) = PA_Sun\approximate_position_of_sun($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection);

    assert($sunRAHour == $expectedSunRAHour);
    assert($sunRAMin == $expectedSunRAMin);
    assert($sunRASec == $expectedSunRASec);
    assert($sunDecDeg == $expectedSunDecDeg);
    assert($sunDecMin == $expectedSunDecMin);
    assert($sunDecSec == $expectedSunDecSec);

    echo "[Approximate Position] [Local Civil Time] {$lctHours}:{$lctMinutes}:{$lctSeconds} [Local Day] {$localMonth}/{$localDay}/{$localYear} = [Sun] RA {$sunRAHour}:{$sunRAMin}:{$sunRASec} Declination {$sunDecDeg} d {$sunDecMin} m {$sunDecSec} s\n";
}

function precise_position_of_sun($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $expectedSunRAHour, $expectedSunRAMin, $expectedSunRASec, $expectedSunDecDeg, $expectedSunDecMin, $expectedSunDecSec)
{
    list($sunRAHour, $sunRAMin, $sunRASec, $sunDecDeg, $sunDecMin, $sunDecSec) = PA_Sun\precise_position_of_sun($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection);

    assert($sunRAHour == $expectedSunRAHour);
    assert($sunRAMin == $expectedSunRAMin);
    assert($sunRASec == $expectedSunRASec);
    assert($sunDecDeg == $expectedSunDecDeg);
    assert($sunDecMin == $expectedSunDecMin);
    assert($sunDecSec == $expectedSunDecSec);

    echo "[Precise Position] [Local Civil Time] {$lctHours}:{$lctMinutes}:{$lctSeconds} [Local Day] {$localMonth}/{$localDay}/{$localYear} = [Sun] RA {$sunRAHour}:{$sunRAMin}:{$sunRASec} Declination {$sunDecDeg} d {$sunDecMin} m {$sunDecSec} s\n";
}

approximate_position_of_sun(0, 0, 0, 27, 7, 2003, false, 0, 8, 23, 33.73, 19, 21, 14.32);

precise_position_of_sun(0, 0, 0, 27, 7, 1988, false, 0, 8, 26, 3.83, 19, 12, 49.72);
