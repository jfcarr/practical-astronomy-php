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

lunar_eclipse_occurrence_details(1, 4, 2015, false, 10, EclipseOccurrence::EclipseCertain, 4, 4, 2015);
