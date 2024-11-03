<?php

namespace PA\Test\Eclipses;

include_once 'lib/PAEclipses.php';
include_once 'lib/PATypes.php';
include_once 'lib/PAUtils.php';

use PA\Eclipses as PA_Eclipses;
use PA\Types\EclipseOccurrence;

use function PA\Utils\descriptive_assert;

function lunar_eclipse_occurrence_details($localDateDay, $localDateMonth, $localDateYear, $isDaylightSaving, $zoneCorrectionHours, $expected_status, $expected_eventDateDay, $expected_eventDateMonth, $expected_eventDateYear)
{
    $title = "Lunar Eclipse Occurrence";

    list($status, $eventDateDay, $eventDateMonth, $eventDateYear) =
        PA_Eclipses\lunar_eclipse_occurrence_details($localDateDay, $localDateMonth, $localDateYear, $isDaylightSaving, $zoneCorrectionHours);

    descriptive_assert("[{$title}] Status", $status->value, $expected_status->value);
    descriptive_assert("[{$title}] Event Date - Day", $eventDateDay, $expected_eventDateDay);
    descriptive_assert("[{$title}] Event Date - Month", $eventDateMonth, $expected_eventDateMonth);
    descriptive_assert("[{$title}] Event Date - Year", $eventDateYear, $expected_eventDateYear);

    echo "[{$title}] PASSED\n";
}

function lunar_eclipse_circumstances($localDateDay, $localDateMonth, $localDateYear, $isDaylightSaving, $zoneCorrectionHours, $expected_lunarEclipseCertainDateDay, $expected_lunarEclipseCertainDateMonth, $expected_lunarEclipseCertainDateYear, $expected_utStartPenPhaseHour, $expected_utStartPenPhaseMinutes, $expected_utStartUmbralPhaseHour, $expected_utStartUmbralPhaseMinutes, $expected_utStartTotalPhaseHour, $expected_utStartTotalPhaseMinutes, $expected_utMidEclipseHour, $expected_utMidEclipseMinutes, $expected_utEndTotalPhaseHour, $expected_utEndTotalPhaseMinutes, $expected_utEndUmbralPhaseHour, $expected_utEndUmbralPhaseMinutes, $expected_utEndPenPhaseHour, $expected_utEndPenPhaseMinutes, $expected_eclipseMagnitude)
{
    $title = "Lunar Eclipse Circumstances";

    list($lunarEclipseCertainDateDay, $lunarEclipseCertainDateMonth, $lunarEclipseCertainDateYear, $utStartPenPhaseHour, $utStartPenPhaseMinutes, $utStartUmbralPhaseHour, $utStartUmbralPhaseMinutes, $utStartTotalPhaseHour, $utStartTotalPhaseMinutes, $utMidEclipseHour, $utMidEclipseMinutes, $utEndTotalPhaseHour, $utEndTotalPhaseMinutes, $utEndUmbralPhaseHour, $utEndUmbralPhaseMinutes, $utEndPenPhaseHour, $utEndPenPhaseMinutes, $eclipseMagnitude) =
        PA_Eclipses\lunar_eclipse_circumstances($localDateDay, $localDateMonth, $localDateYear, $isDaylightSaving, $zoneCorrectionHours);

    descriptive_assert("[{$title}] Date - Day", $lunarEclipseCertainDateDay, $expected_lunarEclipseCertainDateDay);
    descriptive_assert("[{$title}] Date - Month", $lunarEclipseCertainDateMonth, $expected_lunarEclipseCertainDateMonth);
    descriptive_assert("[{$title}] Date - Year", $lunarEclipseCertainDateYear, $expected_lunarEclipseCertainDateYear);
    descriptive_assert("[{$title}] Start Penumbral Phase - Hour", $utStartPenPhaseHour, $expected_utStartPenPhaseHour);
    descriptive_assert("[{$title}] Start Penumbral Phase - Minutes", $utStartPenPhaseMinutes, $expected_utStartPenPhaseMinutes);
    descriptive_assert("[{$title}] Start Umbral Phase - Hour", $utStartUmbralPhaseHour, $expected_utStartUmbralPhaseHour);
    descriptive_assert("[{$title}] Start Umbral Phase - Minutes", $utStartUmbralPhaseMinutes, $expected_utStartUmbralPhaseMinutes);
    descriptive_assert("[{$title}] Start Total Phase - Hour", $utStartTotalPhaseHour, $expected_utStartTotalPhaseHour);
    descriptive_assert("[{$title}] Start Total Phase - Minutes", $utStartTotalPhaseMinutes, $expected_utStartTotalPhaseMinutes);
    descriptive_assert("[{$title}] Mid-Eclipse - Hour", $utMidEclipseHour, $expected_utMidEclipseHour);
    descriptive_assert("[{$title}] Mid-Eclipse - Minutes", $utMidEclipseMinutes, $expected_utMidEclipseMinutes);
    descriptive_assert("[{$title}] End Total Phase - Hour", $utEndTotalPhaseHour, $expected_utEndTotalPhaseHour);
    descriptive_assert("[{$title}] End Total Phase - Minutes", $utEndTotalPhaseMinutes, $expected_utEndTotalPhaseMinutes);
    descriptive_assert("[{$title}] End Umbral Phase - Hour", $utEndUmbralPhaseHour, $expected_utEndUmbralPhaseHour);
    descriptive_assert("[{$title}] End Umbral Phase - Minutes", $utEndUmbralPhaseMinutes, $expected_utEndUmbralPhaseMinutes);
    descriptive_assert("[{$title}] End Penumbral Phase - Hour", $utEndPenPhaseHour, $expected_utEndPenPhaseHour);
    descriptive_assert("[{$title}] End Penumbral Phase - Minutes", $utEndPenPhaseMinutes, $expected_utEndPenPhaseMinutes);
    descriptive_assert("[{$title}] Magnitude", $eclipseMagnitude, $expected_eclipseMagnitude);

    echo "[{$title}] PASSED\n";
}

function solar_eclipse_occurrence($localDateDay, $localDateMonth, $localDateYear, $isDaylightSaving, $zoneCorrectionHours, $expected_status, $expected_eventDateDay, $expected_eventDateMonth, $expected_eventDateYear)
{
    $title = "Solar Eclipse Occurrence";

    list($status, $eventDateDay, $eventDateMonth, $eventDateYear) =
        PA_Eclipses\solar_eclipse_occurrence($localDateDay, $localDateMonth, $localDateYear, $isDaylightSaving, $zoneCorrectionHours);

    descriptive_assert("[{$title}] Status", $status->value, $expected_status->value);
    descriptive_assert("[{$title}] Event Date - Day", $eventDateDay, $expected_eventDateDay);
    descriptive_assert("[{$title}] Event Date - Month", $eventDateMonth, $expected_eventDateMonth);
    descriptive_assert("[{$title}] Event Date - Year", $eventDateYear, $expected_eventDateYear);

    echo "[{$title}] PASSED\n";
}

lunar_eclipse_occurrence_details(1, 4, 2015, false, 10, EclipseOccurrence::EclipseCertain, 4, 4, 2015);

lunar_eclipse_circumstances(1, 4, 2015, false, 10, 4, 4, 2015, 9, 0, 10, 16, 11, 55, 12, 1, 12, 7, 13, 46, 15, 1, 1.01);

solar_eclipse_occurrence(1, 4, 2015, false, 0, EclipseOccurrence::EclipseCertain, 20, 3, 2015);
