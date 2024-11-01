<?php

namespace PA\Eclipses;

use function PA\Macros\full_moon;
use function PA\Macros\julian_date_day;
use function PA\Macros\julian_date_month;
use function PA\Macros\julian_date_year;
use function PA\Macros\lunar_eclipse_occurrence;
use function PA\Macros\universal_time_local_civil_day;
use function PA\Macros\universal_time_local_civil_month;
use function PA\Macros\universal_time_local_civil_year;

include_once 'PAMacros.php';

/** Determine if a lunar eclipse is likely to occur. */
function lunar_eclipse_occurrence_details($localDateDay, $localDateMonth, $localDateYear, $isDaylightSaving, $zoneCorrectionHours)
{
    $daylightSaving = $isDaylightSaving ? 1 : 0;

    $julianDateOfFullMoon = full_moon($daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);

    $gDateOfFullMoonDay = julian_date_day($julianDateOfFullMoon);
    $integerDay = floor($gDateOfFullMoonDay);
    $gDateOfFullMoonMonth = julian_date_month($julianDateOfFullMoon);
    $gDateOfFullMoonYear = julian_date_year($julianDateOfFullMoon);
    $utOfFullMoonHours = $gDateOfFullMoonDay - $integerDay;

    $localCivilDateDay = universal_time_local_civil_day($utOfFullMoonHours, 0.0, 0.0, $daylightSaving, $zoneCorrectionHours, $integerDay, $gDateOfFullMoonMonth, $gDateOfFullMoonYear);
    $localCivilDateMonth = universal_time_local_civil_month($utOfFullMoonHours, 0.0, 0.0, $daylightSaving, $zoneCorrectionHours, $integerDay, $gDateOfFullMoonMonth, $gDateOfFullMoonYear);
    $localCivilDateYear = universal_time_local_civil_year($utOfFullMoonHours, 0.0, 0.0, $daylightSaving, $zoneCorrectionHours, $integerDay, $gDateOfFullMoonMonth, $gDateOfFullMoonYear);

    $eclipseOccurrence = lunar_eclipse_occurrence($daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);

    $status = $eclipseOccurrence;
    $eventDateDay = $localCivilDateDay;
    $eventDateMonth = $localCivilDateMonth;
    $eventDateYear = $localCivilDateYear;

    return array($status, $eventDateDay, $eventDateMonth, $eventDateYear);
}
