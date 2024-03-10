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

function testLocalCivilTimeToUniversalTime($lctHours, $lctMinutes, $lctSeconds, $isDaylightSavings, $zoneCorrection, $localDay, $localMonth, $localYear, $expectedHours, $expectedMinutes, $expectedSeconds, $expectedDay, $expectedMonth, $expectedYear)
{
    list($hours, $minutes, $seconds, $day, $month, $year) = localCivilTimeToUniversalTime($lctHours, $lctMinutes, $lctSeconds, $isDaylightSavings, $zoneCorrection, $localDay, $localMonth, $localYear);

    assert($hours == $expectedHours);
    assert($minutes == $expectedMinutes);
    assert($seconds == $expectedSeconds);
    assert($day == $expectedDay);
    assert($month == $expectedMonth);
    assert($year == $expectedYear);

    echo "[Local] {$lctHours}:{$lctMinutes}:{$lctSeconds} {$localMonth}/{$localDay}/{$localYear} = [Universal] {$hours}:{$minutes}:{$seconds} {$month}/{$day}/{$year}\n";
}

function testUniversalTimeToLocalCivilTime($utHours, $utMinutes, $utSeconds, $isDaylightSavings, $zoneCorrection, $gwDay, $gwMonth, $gwYear, $expectedHours, $expectedMinutes, $expectedSeconds, $expectedDay, $expectedMonth, $expectedYear)
{
    list($hours, $minutes, $seconds, $day, $month, $year) = universalTimeToLocalCivilTime($utHours, $utMinutes, $utSeconds, $isDaylightSavings, $zoneCorrection, $gwDay, $gwMonth, $gwYear);

    assert($hours == $expectedHours);
    assert($minutes == $expectedMinutes);
    assert($seconds == $expectedSeconds);
    assert($day == $expectedDay);
    assert($month == $expectedMonth);
    assert($year == $expectedYear);

    echo "[Universal] {$utHours}:{$utMinutes}:{$utSeconds} {$gwMonth}/{$gwDay}/{$gwYear} = [Local] {$hours}:{$minutes}:{$seconds} {$month}/{$day}/{$year}\n";
}

testDateOfEaster(2023, 4, 9);

testCivilDateToDayNumber(1, 1, 2000, 1);
testCivilDateToDayNumber(3, 1, 2000, 61);
testCivilDateToDayNumber(6, 1, 2003, 152);
testCivilDateToDayNumber(11, 27, 2009, 331);

testCivilTimeToDecimalHours(18, 31, 27, 18.52416667);

testDecimalHoursToCivilTime(18.52416667, 18, 31, 27);

testLocalCivilTimeToUniversalTime(3.0, 37.0, 0.0, true, 4, 1.0, 7, 2013, 22, 37, 0, 30, 6, 2013);

testUniversalTimeToLocalCivilTime(22, 37, 0, true, 4, 30, 6, 2013, 3, 37, 0, 1, 7, 2013);
