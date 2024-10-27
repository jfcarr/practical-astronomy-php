<?php

namespace PA\Test\DateTime;

include_once 'lib/PADateTime.php';

use PA\DateTime as PA_DateTime;

use function PA\Utils\descriptive_assert;

function date_of_easter($inputYear, $expectedMonth, $expectedDay)
{
    $title = "Date of Easter";

    list($month, $day, $year) = PA_DateTime\get_date_of_easter($inputYear);

    descriptive_assert("[{$title}] Month", $month, $expectedMonth);
    descriptive_assert("[{$title}] Day", $day, $expectedDay);
    descriptive_assert("[{$title}] Year", $year, $inputYear);

    echo "[{$title}] PASSED\n";
}

function civil_date_to_day_number($month, $day, $year, $expectedDayNumber)
{
    $title = "Civil Date to Day Number";

    $dayNumber = PA_DateTime\civil_date_to_day_number($month, $day, $year);

    descriptive_assert("[{$title}] Day Number", $dayNumber, $expectedDayNumber);

    echo "[{$title}] ({$expectedDayNumber}) PASSED\n";
}

function civil_time_to_decimal_hours($hours, $minutes, $seconds, $expectedDecimalHours)
{
    $title = "Civil Time to Decimal Hours";

    $decimalHours = round(PA_DateTime\civil_time_to_decimal_hours($hours, $minutes, $seconds), 8);

    descriptive_assert("[{$title}] Decimal Hours", $decimalHours, $expectedDecimalHours);

    echo "[{$title}] PASSED\n";
}

function decimal_hours_to_civil_time($decimalHours, $expectedHours, $expectedMinutes, $expectedSeconds)
{
    $title = "Decimal Hours to Civil Time";

    list($hours, $minutes, $seconds) = PA_DateTime\decimal_hours_to_civil_time($decimalHours);

    descriptive_assert("[{$title}] Hours", $hours, $expectedHours);
    descriptive_assert("[{$title}] Minutes", $minutes, $expectedMinutes);
    descriptive_assert("[{$title}] Minutes", $seconds, $expectedSeconds);

    echo "[{$title}] PASSED\n";
}

function local_civil_time_to_universal_time($lctHours, $lctMinutes, $lctSeconds, $isDaylightSavings, $zoneCorrection, $localDay, $localMonth, $localYear, $expectedHours, $expectedMinutes, $expectedSeconds, $expectedDay, $expectedMonth, $expectedYear)
{
    $title = "Local Civil Time to Universal Time";

    list($hours, $minutes, $seconds, $day, $month, $year) = PA_DateTime\local_civil_time_to_universal_time($lctHours, $lctMinutes, $lctSeconds, $isDaylightSavings, $zoneCorrection, $localDay, $localMonth, $localYear);

    descriptive_assert("[{$title}] Hours", $hours, $expectedHours);
    descriptive_assert("[{$title}] Minutes", $minutes, $expectedMinutes);
    descriptive_assert("[{$title}] Seconds", $seconds, $expectedSeconds);
    descriptive_assert("[{$title}] Day", $day, $expectedDay);
    descriptive_assert("[{$title}] Month", $month, $expectedMonth);
    descriptive_assert("[{$title}] Year", $year, $expectedYear);

    echo "[{$title}] PASSED\n";
}

function universal_time_to_local_civil_time_dt($utHours, $utMinutes, $utSeconds, $isDaylightSavings, $zoneCorrection, $gwDay, $gwMonth, $gwYear, $expectedHours, $expectedMinutes, $expectedSeconds, $expectedDay, $expectedMonth, $expectedYear)
{
    $title = "Universal Time to Local Civil Time";

    list($hours, $minutes, $seconds, $day, $month, $year) = PA_DateTime\universal_time_to_local_civil_time_dt($utHours, $utMinutes, $utSeconds, $isDaylightSavings, $zoneCorrection, $gwDay, $gwMonth, $gwYear);

    descriptive_assert("[{$title}] Hours", $hours, $expectedHours);
    descriptive_assert("[{$title}] Minutes", $minutes, $expectedMinutes);
    descriptive_assert("[{$title}] Seconds", $seconds, $expectedSeconds);
    descriptive_assert("[{$title}] Day", $day, $expectedDay);
    descriptive_assert("[{$title}] Month", $month, $expectedMonth);
    descriptive_assert("[{$title}] Year", $year, $expectedYear);

    echo "[{$title}] PASSED\n";
}

function universal_time_to_greenwich_sidereal_time($utHours, $utMinutes, $utSeconds, $gwDay, $gwMonth, $gwYear, $expectedHours, $expectedMinutes, $expectedSeconds)
{
    $title = "Universal Time to Greenwich Sidereal Time";

    list($hours, $minutes, $seconds) = PA_DateTime\universal_time_to_greenwich_sidereal_time($utHours, $utMinutes, $utSeconds, $gwDay, $gwMonth, $gwYear);

    descriptive_assert("[{$title}] Hours", $hours, $expectedHours);
    descriptive_assert("[{$title}] Minutes", $minutes, $expectedMinutes);
    descriptive_assert("[{$title}] Seconds", $seconds, $expectedSeconds);

    echo "[{$title}] PASSED\n";
}

function greenwich_sidereal_time_to_universal_time($gstHours, $gstMinutes, $gstSeconds, $gwDay, $gwMonth, $gwYear, $expectedHours, $expectedMinutes, $expectedSeconds, $expectedWarningFlag)
{
    $title = "Greenwich Sidereal Time to Universal Time";

    list($hours, $minutes, $seconds, $warningFlag) = PA_DateTime\greenwich_sidereal_time_to_universal_time($gstHours, $gstMinutes, $gstSeconds, $gwDay, $gwMonth, $gwYear);

    descriptive_assert("[{$title}] Hours", $hours, $expectedHours);
    descriptive_assert("[{$title}] Minutes", $minutes, $expectedMinutes);
    descriptive_assert("[{$title}] Seconds", $seconds, $expectedSeconds);
    descriptive_assert("[{$title}] Warning Flag", $warningFlag, $expectedWarningFlag);

    echo "[{$title}] PASSED\n";
}

function greenwich_sidereal_time_to_local_sidereal_time($gstHours, $gstMinutes, $gstSeconds, $geographicalLongitude, $expectedHours, $expectedMinutes, $expectedSeconds)
{
    $title = "Greenwich Sidereal Time to Local Sidereal Time";

    list($hours, $minutes, $seconds)  = PA_DateTime\greenwich_sidereal_time_to_local_sidereal_time($gstHours, $gstMinutes, $gstSeconds, $geographicalLongitude);

    descriptive_assert("[{$title} Hours", $hours, $expectedHours);
    descriptive_assert("[{$title} Minutes", $minutes, $expectedMinutes);
    descriptive_assert("[{$title} Seconds", $seconds, $expectedSeconds);

    echo "[{$title}] PASSED\n";
}

function local_sidereal_time_to_greenwich_sidereal_time($lstHours, $lstMinutes, $lstSeconds, $geographicalLongitude, $expectedHours, $expectedMinutes, $expectedSeconds)
{
    $title = "Local Sidereal Time to Greenwich Sidereal Time";

    list($hours, $minutes, $seconds) = PA_DateTime\local_sidereal_time_to_greenwich_sidereal_time($lstHours, $lstMinutes, $lstSeconds, $geographicalLongitude);

    descriptive_assert("[{$title} Hours", $hours, $expectedHours);
    descriptive_assert("[{$title} Minutes", $minutes, $expectedMinutes);
    descriptive_assert("[{$title} Seconds", $seconds, $expectedSeconds);

    echo "[{$title}] PASSED\n";
}

date_of_easter(2023, 4, 9);

civil_date_to_day_number(1, 1, 2000, 1);
civil_date_to_day_number(3, 1, 2000, 61);
civil_date_to_day_number(6, 1, 2003, 152);
civil_date_to_day_number(11, 27, 2009, 331);

civil_time_to_decimal_hours(18, 31, 27, 18.52416667);

decimal_hours_to_civil_time(18.52416667, 18, 31, 27);

local_civil_time_to_universal_time(3.0, 37.0, 0.0, true, 4, 1.0, 7, 2013, 22, 37, 0, 30, 6, 2013);

universal_time_to_local_civil_time_dt(22, 37, 0, true, 4, 30, 6, 2013, 3, 37, 0, 1, 7, 2013);

universal_time_to_greenwich_sidereal_time(14, 36, 51.67, 22, 4, 1980, 4, 40, 5.23);

greenwich_sidereal_time_to_universal_time(4, 40, 5.23, 22, 4, 1980, 14, 36, 51.67, "OK");

greenwich_sidereal_time_to_local_sidereal_time(4, 40, 5.23, -64, 0, 24, 5.23);

local_sidereal_time_to_greenwich_sidereal_time(0, 24, 5.23, -64, 4, 40, 5.23);
