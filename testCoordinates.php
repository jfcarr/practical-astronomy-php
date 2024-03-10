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

angle_to_decimal_degrees(182, 31, 27, 182.524167);

decimal_degrees_to_angle(182.524167, 182, 31, 27);
