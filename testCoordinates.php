<?php

namespace PA\Test\Coordinates;

include 'lib/PACoordinates.php';

use PA\Coordinates as PA_Coord;

function angle_to_decimal_degrees($degrees, $minutes, $seconds, $expectedDecimalDegrees)
{
    $decimalDegrees = round(PA_Coord\angle_to_decimal_degrees($degrees, $minutes, $seconds), 6);

    assert($decimalDegrees  == $expectedDecimalDegrees);

    echo "[Angle] {$degrees} degrees, {$minutes} minutes {$seconds} seconds = [Decimal Degrees] {$decimalDegrees} degrees\n";
}

function decimal_degrees_to_angle($decimalDegrees, $expectedDegrees, $expectedMinutes, $expectedSeconds)
{
    list($degrees, $minutes, $seconds) = PA_Coord\decimal_degrees_to_angle($decimalDegrees);

    assert($degrees == $expectedDegrees);
    assert($minutes == $expectedMinutes);
    assert($seconds == $expectedSeconds);

    echo "[Decimal Degrees] {$decimalDegrees} = [Angle] {$degrees} degrees, {$minutes} minutes {$seconds} seconds\n";
}

function right_ascension_to_hour_angle($raHours, $raMinutes, $raSeconds, $lctHours, $lctMinutes, $lctSeconds, $isDaylightSavings, $zoneCorrection, $localDay, $localMonth, $localYear, $geographicalLongitude, $expectedHourAngleHours, $expectedHourAngleMinutes, $expectedHourAngleSeconds)
{
    list($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds) = PA_Coord\right_ascension_to_hour_angle($raHours, $raMinutes, $raSeconds, $lctHours, $lctMinutes, $lctSeconds, $isDaylightSavings, $zoneCorrection, $localDay, $localMonth, $localYear, $geographicalLongitude);

    assert($hourAngleHours == $expectedHourAngleHours);
    assert($hourAngleMinutes == $expectedHourAngleMinutes);
    assert($hourAngleSeconds == $expectedHourAngleSeconds);

    echo "[Right Ascension] RA {$raHours}:{$raMinutes}:{$raSeconds} LCT {$lctHours}:{$lctMinutes}:{$lctSeconds} = [Hour Angle] {$hourAngleHours}:{$hourAngleMinutes}:{$hourAngleSeconds}\n";
}

function hour_angle_to_right_ascension($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $lctHours, $lctMinutes, $lctSeconds, $isDaylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear, $geographicalLongitude, $expectedrightAscensionHours, $expectedRightAscensionMinutes, $expectedRightAscensionSeconds)
{
    list($rightAscensionHours, $rightAscensionMinutes, $rightAscensionSeconds) = PA_Coord\hour_angle_to_right_ascension($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $lctHours, $lctMinutes, $lctSeconds, $isDaylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear, $geographicalLongitude);

    assert($rightAscensionHours == $expectedrightAscensionHours);
    assert($rightAscensionMinutes == $expectedRightAscensionMinutes);
    assert($rightAscensionSeconds == $expectedRightAscensionSeconds);

    echo "[Hour Angle] HA {$hourAngleHours}:{$hourAngleMinutes}:{$hourAngleSeconds} LCT {$lctHours}:{$lctMinutes}:{$lctSeconds} = [Right Ascension] {$rightAscensionHours}:{$rightAscensionMinutes}:{$rightAscensionSeconds} \n";
}

angle_to_decimal_degrees(182, 31, 27, 182.524167);

decimal_degrees_to_angle(182.524167, 182, 31, 27);

right_ascension_to_hour_angle(18, 32, 21, 14, 36, 51.67, false, -4, 22, 4, 1980, -64, 9, 52, 23.66);

hour_angle_to_right_ascension(9, 52, 23.66, 14, 36, 51.67, false, -4, 22, 4, 1980, -64, 18, 32, 21);
