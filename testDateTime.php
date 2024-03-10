<?php
include 'lib/PADateTime.php';

function testDateOfEaster($inputYear, $expectedMonth, $expectedDay)
{
    list($month, $day, $year) = getDateOfEaster($inputYear);

    assert($month == $expectedMonth);
    assert($day = $expectedDay);
    assert($year = $inputYear);

    echo "Date of Easter for {$inputYear} is {$month}/{$day}/{$year}\n";
}

function testCivilDateToDayNumber($month, $day, $year, $expectedDayNumber)
{
    $dayNumber = civilDateToDayNumber($month, $day, $year);

    assert($dayNumber == $expectedDayNumber);

    echo "{$month}/{$day}/{$year} is day {$dayNumber} of the year\n";
}

function testCivilTimeToDecimalHours($hours, $minutes, $seconds, $expectedDecimalHours)
{
    $decimalHours = round(civilTimeToDecimalHours($hours, $minutes, $seconds), 8);

    assert($decimalHours == $expectedDecimalHours);

    echo "Decimal Hours for {$hours}:{$minutes}:{$seconds} are {$decimalHours}\n";
}

function testDecimalHoursToCivilTime($decimalHours, $expectedHours, $expectedMinutes, $expectedSeconds)
{
    list($hours, $minutes, $seconds) = decimalHoursToCivilTime($decimalHours);

    assert($hours == $expectedHours);
    assert($minutes == $expectedMinutes);
    assert($seconds == $expectedSeconds);

    echo "Hours, minutes, and seconds for {$decimalHours} are {$hours}:{$minutes}:{$seconds}\n";
}

testDateOfEaster(2023, 4, 9);

testCivilDateToDayNumber(1, 1, 2000, 1);
testCivilDateToDayNumber(3, 1, 2000, 61);
testCivilDateToDayNumber(6, 1, 2003, 152);
testCivilDateToDayNumber(11, 27, 2009, 331);

testCivilTimeToDecimalHours(18, 31, 27, 18.52416667);

testDecimalHoursToCivilTime(18.52416667, 18, 31, 27);
