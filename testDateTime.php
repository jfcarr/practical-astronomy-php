<?php
include 'lib/PADateTime.php';

function test_date_of_easter($inputYear, $expectedMonth, $expectedDay)
{
    list($month, $day, $year) = get_date_of_easter($inputYear);

    assert($month == $expectedMonth);
    assert($day = $expectedDay);
    assert($year = $inputYear);

    echo "Date of Easter for {$inputYear} is {$month}/{$day}/{$year}\n";
}

function test_civil_date_to_day_number($month, $day, $year, $expectedDayNumber)
{
    $dayNumber = civil_date_to_day_number($month, $day, $year);

    assert($dayNumber == $expectedDayNumber);

    echo "{$month}/{$day}/{$year} is day {$dayNumber} of the year\n";
}

function test_civil_time_to_decimal_hours($hours, $minutes, $seconds, $expectedDecimalHours)
{
    $decimalHours = round(civil_time_to_decimal_hours($hours, $minutes, $seconds), 8);

    assert($decimalHours == $expectedDecimalHours);

    echo "Decimal Hours for {$hours}:{$minutes}:{$seconds} are {$decimalHours}\n";
}

function test_decimal_hours_to_civil_time($decimalHours, $expectedHours, $expectedMinutes, $expectedSeconds)
{
    list($hours, $minutes, $seconds) = decimal_hours_to_civil_time($decimalHours);

    assert($hours == $expectedHours);
    assert($minutes == $expectedMinutes);
    assert($seconds == $expectedSeconds);

    echo "Hours, minutes, and seconds for {$decimalHours} are {$hours}:{$minutes}:{$seconds}\n";
}

function test_local_civil_time_to_universal_time($lctHours, $lctMinutes, $lctSeconds, $isDaylightSavings, $zoneCorrection, $localDay, $localMonth, $localYear, $expectedHours, $expectedMinutes, $expectedSeconds, $expectedDay, $expectedMonth, $expectedYear)
{
    list($hours, $minutes, $seconds, $day, $month, $year) = local_civil_time_to_universal_time($lctHours, $lctMinutes, $lctSeconds, $isDaylightSavings, $zoneCorrection, $localDay, $localMonth, $localYear);

    assert($hours == $expectedHours);
    assert($minutes == $expectedMinutes);
    assert($seconds == $expectedSeconds);
    assert($day == $expectedDay);
    assert($month == $expectedMonth);
    assert($year == $expectedYear);

    echo "[Local] {$lctHours}:{$lctMinutes}:{$lctSeconds} {$localMonth}/{$localDay}/{$localYear} = [Universal] {$hours}:{$minutes}:{$seconds} {$month}/{$day}/{$year}\n";
}

function test_universal_time_to_local_civil_time($utHours, $utMinutes, $utSeconds, $isDaylightSavings, $zoneCorrection, $gwDay, $gwMonth, $gwYear, $expectedHours, $expectedMinutes, $expectedSeconds, $expectedDay, $expectedMonth, $expectedYear)
{
    list($hours, $minutes, $seconds, $day, $month, $year) = universal_time_to_local_civil_time($utHours, $utMinutes, $utSeconds, $isDaylightSavings, $zoneCorrection, $gwDay, $gwMonth, $gwYear);

    assert($hours == $expectedHours);
    assert($minutes == $expectedMinutes);
    assert($seconds == $expectedSeconds);
    assert($day == $expectedDay);
    assert($month == $expectedMonth);
    assert($year == $expectedYear);

    echo "[Universal] {$utHours}:{$utMinutes}:{$utSeconds} {$gwMonth}/{$gwDay}/{$gwYear} = [Local] {$hours}:{$minutes}:{$seconds} {$month}/{$day}/{$year}\n";
}

test_date_of_easter(2023, 4, 9);

test_civil_date_to_day_number(1, 1, 2000, 1);
test_civil_date_to_day_number(3, 1, 2000, 61);
test_civil_date_to_day_number(6, 1, 2003, 152);
test_civil_date_to_day_number(11, 27, 2009, 331);

test_civil_time_to_decimal_hours(18, 31, 27, 18.52416667);

test_decimal_hours_to_civil_time(18.52416667, 18, 31, 27);

test_local_civil_time_to_universal_time(3.0, 37.0, 0.0, true, 4, 1.0, 7, 2013, 22, 37, 0, 30, 6, 2013);

test_universal_time_to_local_civil_time(22, 37, 0, true, 4, 30, 6, 2013, 3, 37, 0, 1, 7, 2013);
