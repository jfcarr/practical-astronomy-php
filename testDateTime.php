<?php

namespace PA\Test\DateTime;

include_once 'lib/PADateTime.php';

use PA\DateTime as PA_DateTime;

function date_of_easter($inputYear, $expectedMonth, $expectedDay)
{
    list($month, $day, $year) = PA_DateTime\get_date_of_easter($inputYear);

    assert($month == $expectedMonth);
    assert($day = $expectedDay);
    assert($year = $inputYear);

    echo "Date of Easter for {$inputYear} is {$month}/{$day}/{$year}\n";
}

function civil_date_to_day_number($month, $day, $year, $expectedDayNumber)
{
    $dayNumber = PA_DateTime\civil_date_to_day_number($month, $day, $year);

    assert($dayNumber == $expectedDayNumber);

    echo "{$month}/{$day}/{$year} is day {$dayNumber} of the year\n";
}

function civil_time_to_decimal_hours($hours, $minutes, $seconds, $expectedDecimalHours)
{
    $decimalHours = round(PA_DateTime\civil_time_to_decimal_hours($hours, $minutes, $seconds), 8);

    assert($decimalHours == $expectedDecimalHours);

    echo "Decimal Hours for {$hours}:{$minutes}:{$seconds} are {$decimalHours}\n";
}

function decimal_hours_to_civil_time($decimalHours, $expectedHours, $expectedMinutes, $expectedSeconds)
{
    list($hours, $minutes, $seconds) = PA_DateTime\decimal_hours_to_civil_time($decimalHours);

    assert($hours == $expectedHours);
    assert($minutes == $expectedMinutes);
    assert($seconds == $expectedSeconds);

    echo "Hours, minutes, and seconds for {$decimalHours} are {$hours}:{$minutes}:{$seconds}\n";
}

function local_civil_time_to_universal_time($lctHours, $lctMinutes, $lctSeconds, $isDaylightSavings, $zoneCorrection, $localDay, $localMonth, $localYear, $expectedHours, $expectedMinutes, $expectedSeconds, $expectedDay, $expectedMonth, $expectedYear)
{
    list($hours, $minutes, $seconds, $day, $month, $year) = PA_DateTime\local_civil_time_to_universal_time($lctHours, $lctMinutes, $lctSeconds, $isDaylightSavings, $zoneCorrection, $localDay, $localMonth, $localYear);

    assert($hours == $expectedHours);
    assert($minutes == $expectedMinutes);
    assert($seconds == $expectedSeconds);
    assert($day == $expectedDay);
    assert($month == $expectedMonth);
    assert($year == $expectedYear);

    echo "[Local] {$lctHours}:{$lctMinutes}:{$lctSeconds} {$localMonth}/{$localDay}/{$localYear} = [Universal] {$hours}:{$minutes}:{$seconds} {$month}/{$day}/{$year}\n";
}

function universal_time_to_local_civil_time($utHours, $utMinutes, $utSeconds, $isDaylightSavings, $zoneCorrection, $gwDay, $gwMonth, $gwYear, $expectedHours, $expectedMinutes, $expectedSeconds, $expectedDay, $expectedMonth, $expectedYear)
{
    list($hours, $minutes, $seconds, $day, $month, $year) = PA_DateTime\universal_time_to_local_civil_time_dt($utHours, $utMinutes, $utSeconds, $isDaylightSavings, $zoneCorrection, $gwDay, $gwMonth, $gwYear);

    assert($hours == $expectedHours);
    assert($minutes == $expectedMinutes);
    assert($seconds == $expectedSeconds);
    assert($day == $expectedDay);
    assert($month == $expectedMonth);
    assert($year == $expectedYear);

    echo "[Universal] {$utHours}:{$utMinutes}:{$utSeconds} {$gwMonth}/{$gwDay}/{$gwYear} = [Local] {$hours}:{$minutes}:{$seconds} {$month}/{$day}/{$year}\n";
}

function universal_time_to_greenwich_sidereal_time($utHours, $utMinutes, $utSeconds, $gwDay, $gwMonth, $gwYear, $expectedHours, $expectedMinutes, $expectedSeconds)
{
    list($hours, $minutes, $seconds) = PA_DateTime\universal_time_to_greenwich_sidereal_time($utHours, $utMinutes, $utSeconds, $gwDay, $gwMonth, $gwYear);

    assert($hours == $expectedHours);
    assert($minutes == $expectedMinutes);
    assert($seconds == $expectedSeconds);

    echo "[Universal] {$gwMonth}/{$gwDay}/{$gwYear} {$utHours}:{$utMinutes}:{$utSeconds} = [Greenwich] {$hours}:{$minutes}:{$seconds}\n";
}

function greenwich_sidereal_time_to_universal_time($gstHours, $gstMinutes, $gstSeconds, $gwDay, $gwMonth, $gwYear, $expectedHours, $expectedMinutes, $expectedSeconds, $expectedWarningFlag)
{
    list($hours, $minutes, $seconds, $warningFlag) = PA_DateTime\greenwich_sidereal_time_to_universal_time($gstHours, $gstMinutes, $gstSeconds, $gwDay, $gwMonth, $gwYear);

    assert($hours == $expectedHours);
    assert($minutes == $expectedMinutes);
    assert($seconds == $expectedSeconds);
    assert($warningFlag == $expectedWarningFlag);

    echo "[Greenwich] {$gwMonth}/{$gwDay}/{$gwYear} {$gstHours}:{$gstMinutes}:{$gstSeconds} = [Universal] {$hours}:{$minutes}:{$seconds}\n";
}

function greenwich_sidereal_time_to_local_sidereal_time($gstHours, $gstMinutes, $gstSeconds, $geographicalLongitude, $expectedHours, $expectedMinutes, $expectedSeconds)
{
    list($hours, $minutes, $seconds)  = PA_DateTime\greenwich_sidereal_time_to_local_sidereal_time($gstHours, $gstMinutes, $gstSeconds, $geographicalLongitude);

    assert($hours == $expectedHours);
    assert($minutes == $expectedMinutes);
    assert($seconds == $expectedSeconds);

    echo "[Greenwich] {$gstHours}:{$gstMinutes}:{$gstSeconds} = [Sidereal] {$hours}:{$minutes}:{$seconds}\n";
}

function local_sidereal_time_to_greenwich_sidereal_time($lstHours, $lstMinutes, $lstSeconds, $geographicalLongitude, $expectedHours, $expectedMinutes, $expectedSeconds)
{
    list($hours, $minutes, $seconds) = PA_DateTime\local_sidereal_time_to_greenwich_sidereal_time($lstHours, $lstMinutes, $lstSeconds, $geographicalLongitude);

    assert($hours == $expectedHours);
    assert($minutes == $expectedMinutes);
    assert($seconds == $expectedSeconds);

    echo "[Sidereal] {$lstHours}:{$lstMinutes}:{$lstSeconds} = [Greenwich] {$hours}:{$minutes}:{$seconds}\n";
}

date_of_easter(2023, 4, 9);

civil_date_to_day_number(1, 1, 2000, 1);
civil_date_to_day_number(3, 1, 2000, 61);
civil_date_to_day_number(6, 1, 2003, 152);
civil_date_to_day_number(11, 27, 2009, 331);

civil_time_to_decimal_hours(18, 31, 27, 18.52416667);

decimal_hours_to_civil_time(18.52416667, 18, 31, 27);

local_civil_time_to_universal_time(3.0, 37.0, 0.0, true, 4, 1.0, 7, 2013, 22, 37, 0, 30, 6, 2013);

universal_time_to_local_civil_time(22, 37, 0, true, 4, 30, 6, 2013, 3, 37, 0, 1, 7, 2013);

universal_time_to_greenwich_sidereal_time(14, 36, 51.67, 22, 4, 1980, 4, 40, 5.23);

greenwich_sidereal_time_to_universal_time(4, 40, 5.23, 22, 4, 1980, 14, 36, 51.67, "OK");

greenwich_sidereal_time_to_local_sidereal_time(4, 40, 5.23, -64, 0, 24, 5.23);

local_sidereal_time_to_greenwich_sidereal_time(0, 24, 5.23, -64, 4, 40, 5.23);
