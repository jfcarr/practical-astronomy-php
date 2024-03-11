<?php

namespace PA\MathExtensions;

/**
 * Returns the angle whose cosine is the specified number.
 */
function a_cosine($d)
{
    return acos($d);
}

/**
 * Returns the angle whose tangent is the specified number.
 */
function angle_tangent($d)
{
    return atan($d);
}

/**
 * Returns the angle whose tangent is the quotient of two specified numbers.
 */
function angle_tangent2($y, $x)
{
    return atan2($y, $x);
}

/**
 * Returns the asine
 */
function a_sine($d)
{
    return asin($d);
}

/**
 * Returns the cosine
 */
function cosine($d)
{
    return cos($d);
}

/**
 * Calculate base 10 logarithm
 */
function log10($d)
{
    return log10($d);
}

/**
 * Returns the sine
 */
function sine($d)
{
    return sin($d);
}

/**
 * Convert degrees to radians
 */
function to_radians($degrees)
{
    return $degrees * (pi() / 180);
}
