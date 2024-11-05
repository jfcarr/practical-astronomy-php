<?php

namespace PA\Eclipses;

use function PA\Macros\decimal_hours_hour;
use function PA\Macros\decimal_hours_minute;
use function PA\Macros\full_moon;
use function PA\Macros\julian_date_day;
use function PA\Macros\julian_date_month;
use function PA\Macros\julian_date_year;
use function PA\Macros\lunar_eclipse_occurrence;
use function PA\Macros\mag_lunar_eclipse;
use function PA\Macros\mag_solar_eclipse;
use function PA\Macros\new_moon;
use function PA\Macros\solar_eclipse_occurrence as solar_eclipse_occurrence_ma;
use function PA\Macros\universal_time_local_civil_day;
use function PA\Macros\universal_time_local_civil_month;
use function PA\Macros\universal_time_local_civil_year;
use function PA\Macros\ut_end_total_lunar_eclipse;
use function PA\Macros\ut_end_umbra_lunar_eclipse;
use function PA\Macros\ut_first_contact_lunar_eclipse;
use function PA\Macros\ut_first_contact_solar_eclipse;
use function PA\Macros\ut_last_contact_lunar_eclipse;
use function PA\Macros\ut_last_contact_solar_eclipse;
use function PA\Macros\ut_max_lunar_eclipse;
use function PA\Macros\ut_max_solar_eclipse;
use function PA\Macros\ut_start_total_lunar_eclipse;
use function PA\Macros\ut_start_umbra_lunar_eclipse;

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

/** * Calculate the circumstances of a lunar eclipse.  */
function lunar_eclipse_circumstances($localDateDay, $localDateMonth, $localDateYear, $isDaylightSaving, $zoneCorrectionHours)
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

    $utMaxEclipse = ut_max_lunar_eclipse($localDateDay, $localDateMonth, $localDateYear, $daylightSaving, $zoneCorrectionHours);
    $utFirstContact = ut_first_contact_lunar_eclipse($localDateDay, $localDateMonth, $localDateYear, $daylightSaving, $zoneCorrectionHours);
    $utLastContact = ut_last_contact_lunar_eclipse($localDateDay, $localDateMonth, $localDateYear, $daylightSaving, $zoneCorrectionHours);
    $utStartUmbralPhase = ut_start_umbra_lunar_eclipse($localDateDay, $localDateMonth, $localDateYear, $daylightSaving, $zoneCorrectionHours);
    $utEndUmbralPhase = ut_end_umbra_lunar_eclipse($localDateDay, $localDateMonth, $localDateYear, $daylightSaving, $zoneCorrectionHours);
    $utStartTotalPhase = ut_start_total_lunar_eclipse($localDateDay, $localDateMonth, $localDateYear, $daylightSaving, $zoneCorrectionHours);
    $utEndTotalPhase = ut_end_total_lunar_eclipse($localDateDay, $localDateMonth, $localDateYear, $daylightSaving, $zoneCorrectionHours);

    $eclipseMagnitude1 = mag_lunar_eclipse($localDateDay, $localDateMonth, $localDateYear, $daylightSaving, $zoneCorrectionHours);

    $lunarEclipseCertainDateDay = $localCivilDateDay;
    $lunarEclipseCertainDateMonth = $localCivilDateMonth;
    $lunarEclipseCertainDateYear = $localCivilDateYear;

    $utStartPenPhaseHour = ($utFirstContact == -99.0) ? -99.0 : decimal_hours_hour($utFirstContact + 0.008333);
    $utStartPenPhaseMinutes = ($utFirstContact == -99.0) ? -99.0 : decimal_hours_minute($utFirstContact + 0.008333);

    $utStartUmbralPhaseHour = ($utStartUmbralPhase == -99.0) ? -99.0 : decimal_hours_hour($utStartUmbralPhase + 0.008333);
    $utStartUmbralPhaseMinutes = ($utStartUmbralPhase == -99.0) ? -99.0 : decimal_hours_minute($utStartUmbralPhase + 0.008333);

    $utStartTotalPhaseHour = ($utStartTotalPhase == -99.0) ? -99.0 : decimal_hours_hour($utStartTotalPhase + 0.008333);
    $utStartTotalPhaseMinutes = ($utStartTotalPhase == -99.0) ? -99.0 : decimal_hours_minute($utStartTotalPhase + 0.008333);

    $utMidEclipseHour = ($utMaxEclipse == -99.0) ? -99.0 : decimal_hours_hour($utMaxEclipse + 0.008333);
    $utMidEclipseMinutes = ($utMaxEclipse == -99.0) ? -99.0 : decimal_hours_minute($utMaxEclipse + 0.008333);

    $utEndTotalPhaseHour = ($utEndTotalPhase == -99.0) ? -99.0 : decimal_hours_hour($utEndTotalPhase + 0.008333);
    $utEndTotalPhaseMinutes = ($utEndTotalPhase == -99.0) ? -99.0 : decimal_hours_minute($utEndTotalPhase + 0.008333);

    $utEndUmbralPhaseHour = ($utEndUmbralPhase == -99.0) ? -99.0 : decimal_hours_hour($utEndUmbralPhase + 0.008333);
    $utEndUmbralPhaseMinutes = ($utEndUmbralPhase == -99.0) ? -99.0 : decimal_hours_minute($utEndUmbralPhase + 0.008333);

    $utEndPenPhaseHour = ($utLastContact == -99.0) ? -99.0 : decimal_hours_hour($utLastContact + 0.008333);
    $utEndPenPhaseMinutes = ($utLastContact == -99.0) ? -99.0 : decimal_hours_minute($utLastContact + 0.008333);

    $eclipseMagnitude = ($eclipseMagnitude1 == -99.0) ? -99.0 : round($eclipseMagnitude1, 2);

    return array($lunarEclipseCertainDateDay, $lunarEclipseCertainDateMonth, $lunarEclipseCertainDateYear, $utStartPenPhaseHour, $utStartPenPhaseMinutes, $utStartUmbralPhaseHour, $utStartUmbralPhaseMinutes, $utStartTotalPhaseHour, $utStartTotalPhaseMinutes, $utMidEclipseHour, $utMidEclipseMinutes, $utEndTotalPhaseHour, $utEndTotalPhaseMinutes, $utEndUmbralPhaseHour, $utEndUmbralPhaseMinutes, $utEndPenPhaseHour, $utEndPenPhaseMinutes, $eclipseMagnitude);
}

/** Determine if a solar eclipse is likely to occur. */
function solar_eclipse_occurrence($localDateDay, $localDateMonth, $localDateYear, $isDaylightSaving, $zoneCorrectionHours)
{
    $daylightSaving = $isDaylightSaving ? 1 : 0;

    $julianDateOfNewMoon = new_moon($daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
    $gDateOfNewMoonDay = julian_date_day($julianDateOfNewMoon);
    $integerDay = floor($gDateOfNewMoonDay);
    $gDateOfNewMoonMonth = julian_date_month($julianDateOfNewMoon);
    $gDateOfNewMoonYear = julian_date_year($julianDateOfNewMoon);
    $utOfNewMoonHours = $gDateOfNewMoonDay - $integerDay;

    $localCivilDateDay = universal_time_local_civil_day($utOfNewMoonHours, 0.0, 0.0, $daylightSaving, $zoneCorrectionHours, $integerDay, $gDateOfNewMoonMonth, $gDateOfNewMoonYear);
    $localCivilDateMonth = universal_time_local_civil_month($utOfNewMoonHours, 0.0, 0.0, $daylightSaving, $zoneCorrectionHours, $integerDay, $gDateOfNewMoonMonth, $gDateOfNewMoonYear);
    $localCivilDateYear = universal_time_local_civil_year($utOfNewMoonHours, 0.0, 0.0, $daylightSaving, $zoneCorrectionHours, $integerDay, $gDateOfNewMoonMonth, $gDateOfNewMoonYear);

    $eclipseOccurrence = solar_eclipse_occurrence_ma($daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
    $status = $eclipseOccurrence;
    $eventDateDay = $localCivilDateDay;
    $eventDateMonth = $localCivilDateMonth;
    $eventDateYear = $localCivilDateYear;

    return array($status, $eventDateDay, $eventDateMonth, $eventDateYear);
}

/** Calculate the circumstances of a solar eclipse. */
function solar_eclipse_circumstances($localDateDay, $localDateMonth, $localDateYear, $isDaylightSaving, $zoneCorrectionHours, $geogLongitudeDeg, $geogLatitudeDeg)
{
    $daylightSaving = $isDaylightSaving ? 1 : 0;

    $julianDateOfNewMoon = new_moon($daylightSaving, $zoneCorrectionHours, $localDateDay, $localDateMonth, $localDateYear);
    $gDateOfNewMoonDay = julian_date_day($julianDateOfNewMoon);
    $integerDay = floor($gDateOfNewMoonDay);
    $gDateOfNewMoonMonth = julian_date_month($julianDateOfNewMoon);
    $gDateOfNewMoonYear = julian_date_year($julianDateOfNewMoon);
    $utOfNewMoonHours = $gDateOfNewMoonDay - $integerDay;
    $localCivilDateDay = universal_time_local_civil_day($utOfNewMoonHours, 0.0, 0.0, $daylightSaving, $zoneCorrectionHours, $integerDay, $gDateOfNewMoonMonth, $gDateOfNewMoonYear);
    $localCivilDateMonth = universal_time_local_civil_month($utOfNewMoonHours, 0.0, 0.0, $daylightSaving, $zoneCorrectionHours, $integerDay, $gDateOfNewMoonMonth, $gDateOfNewMoonYear);
    $localCivilDateYear = universal_time_local_civil_year($utOfNewMoonHours, 0.0, 0.0, $daylightSaving, $zoneCorrectionHours, $integerDay, $gDateOfNewMoonMonth, $gDateOfNewMoonYear);

    $utMaxEclipse = ut_max_solar_eclipse($localDateDay, $localDateMonth, $localDateYear, $daylightSaving, $zoneCorrectionHours, $geogLongitudeDeg, $geogLatitudeDeg);
    $utFirstContact = ut_first_contact_solar_eclipse($localDateDay, $localDateMonth, $localDateYear, $daylightSaving, $zoneCorrectionHours, $geogLongitudeDeg, $geogLatitudeDeg);
    $utLastContact = ut_last_contact_solar_eclipse($localDateDay, $localDateMonth, $localDateYear, $daylightSaving, $zoneCorrectionHours, $geogLongitudeDeg, $geogLatitudeDeg);
    $magnitude = mag_solar_eclipse($localDateDay, $localDateMonth, $localDateYear, $daylightSaving, $zoneCorrectionHours, $geogLongitudeDeg, $geogLatitudeDeg);

    $solarEclipseCertainDateDay = $localCivilDateDay;
    $solarEclipseCertainDateMonth = $localCivilDateMonth;
    $solarEclipseCertainDateYear = $localCivilDateYear;

    $utFirstContactHour = ($utFirstContact == -99.0)
        ? -99.0
        : decimal_hours_hour($utFirstContact + 0.008333);
    $utFirstContactMinutes = ($utFirstContact == -99.0)
        ? -99.0
        : decimal_hours_minute($utFirstContact + 0.008333);

    $utMidEclipseHour = ($utMaxEclipse == -99.0)
        ? -99.0
        : decimal_hours_hour($utMaxEclipse + 0.008333);
    $utMidEclipseMinutes = ($utMaxEclipse == -99.0)
        ? -99.0
        : decimal_hours_minute($utMaxEclipse + 0.008333);

    $utLastContactHour = ($utLastContact == -99.0)
        ? -99.0
        : decimal_hours_hour($utLastContact + 0.008333);
    $utLastContactMinutes = ($utLastContact == -99.0)
        ? -99.0
        : decimal_hours_minute($utLastContact + 0.008333);

    $eclipseMagnitude = ($magnitude == -99.0)
        ? -99.0
        : round($magnitude, 3);

    return array($solarEclipseCertainDateDay, $solarEclipseCertainDateMonth, $solarEclipseCertainDateYear, $utFirstContactHour, $utFirstContactMinutes, $utMidEclipseHour, $utMidEclipseMinutes, $utLastContactHour, $utLastContactMinutes, $eclipseMagnitude);
}
