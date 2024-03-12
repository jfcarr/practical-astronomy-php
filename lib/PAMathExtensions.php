<?php

namespace PA\MathExtensions;

/**
 * Convert degrees to radians
 */
function degrees_to_radians($degrees)
{
    return $degrees * (pi() / 180);
}

/**
 * Convert radians to degrees
 */
function radians_to_degrees($radians)
{
    return $radians * pi() / 180;
}
