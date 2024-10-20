<?php

namespace PA\Utils;

/**
 * Determine if year is a leap year. 
 */
function is_leap_year($inputYear)
{
    $year = $inputYear;

    if ($year % 4 == 0) {
        if ($year % 100 == 0)
            return ($year % 400 == 0) ? true : false;
        else
            return true;
    } else
        return false;
}

/**
 * Assert that two values are equal and display a descriptive message if they aren't.
 */
function descriptive_assert($field_name, $actual_value, $expected_value)
{
    assert($actual_value == $expected_value, "[{$field_name}] Expected {$expected_value}, got {$actual_value}");
}
