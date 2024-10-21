<?php

namespace PA\Test\Sun;

include_once 'lib/PASun.php';
include_once 'lib/PAUtils.php';

use PA\Sun as PA_Sun;

use PA\Types\RiseSetStatus;
use PA\Types\TwilightStatus;
use PA\Types\TwilightType;

use function PA\Utils\descriptive_assert;

function approximate_position_of_sun($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $expectedSunRAHour, $expectedSunRAMin, $expectedSunRASec, $expectedSunDecDeg, $expectedSunDecMin, $expectedSunDecSec)
{
    $title = "Approximate Position of Sun";

    list($sunRAHour, $sunRAMin, $sunRASec, $sunDecDeg, $sunDecMin, $sunDecSec) = PA_Sun\approximate_position_of_sun($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection);

    descriptive_assert("[{$title}] RA Hour", $sunRAHour, $expectedSunRAHour);
    descriptive_assert("[{$title}] RA Minutes", $sunRAMin, $expectedSunRAMin);
    descriptive_assert("[{$title}] RA Seconds", $sunRASec, $expectedSunRASec);
    descriptive_assert("[{$title}] Dec Degrees", $sunDecDeg, $expectedSunDecDeg);
    descriptive_assert("[{$title}] Dec Minutes", $sunDecMin, $expectedSunDecMin);
    descriptive_assert("[{$title}] Dec Seconds", $sunDecSec, $expectedSunDecSec);

    echo "[{$title}] PASSED\n";
}

function precise_position_of_sun($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $expectedSunRAHour, $expectedSunRAMin, $expectedSunRASec, $expectedSunDecDeg, $expectedSunDecMin, $expectedSunDecSec)
{
    $title = "Precise Position of Sun";

    list($sunRAHour, $sunRAMin, $sunRASec, $sunDecDeg, $sunDecMin, $sunDecSec) = PA_Sun\precise_position_of_sun($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection);

    descriptive_assert("[{$title}] RA Hour", $sunRAHour, $expectedSunRAHour);
    descriptive_assert("[{$title}] RA Minutes", $sunRAMin, $expectedSunRAMin);
    descriptive_assert("[{$title}] RA Seconds", $sunRASec, $expectedSunRASec);
    descriptive_assert("[{$title}] Dec Degrees", $sunDecDeg, $expectedSunDecDeg);
    descriptive_assert("[{$title}] Dec Minutes", $sunDecMin, $expectedSunDecMin);
    descriptive_assert("[{$title}] Dec Seconds", $sunDecSec, $expectedSunDecSec);

    echo "[{$title}] PASSED\n";
}

function sun_distance_and_angular_size($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $expectedSunDistKm, $expectedSunAngSizeDeg, $expectedSunAngSizeMin, $expectedSunAngSizeSec)
{
    $title = "Sun Distance and Angular Size";

    list($sunDistKm, $sunAngSizeDeg, $sunAngSizeMin, $sunAngSizeSec) = PA_Sun\sun_distance_and_angular_size($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection);

    descriptive_assert("[{$title}] Distance km", $sunDistKm, $expectedSunDistKm);
    descriptive_assert("[{$title}] Angular Size degrees", $sunAngSizeDeg, $expectedSunAngSizeDeg);
    descriptive_assert("[{$title}] Angular Size minutes", $sunAngSizeMin, $expectedSunAngSizeMin);
    descriptive_assert("[{$title}] Angular Size seconds", $sunAngSizeSec, $expectedSunAngSizeSec);

    echo "[{$title}] PASSED\n";
}

function sunrise_and_sunset($localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $geographicalLongDeg, $geographicalLatDeg, $expected_localSunriseHour, $expected_localSunriseMinute, $expected_localSunsetHour, $expected_localSunsetMinute, $expected_azimuthOfSunriseDeg, $expected_azimuthOfSunsetDeg, $expected_status)
{
    $title = "Sunrise and Sunset";

    list($localSunriseHour, $localSunriseMinute, $localSunsetHour, $localSunsetMinute, $azimuthOfSunriseDeg, $azimuthOfSunsetDeg, $status) = PA_Sun\sunrise_and_sunset($localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $geographicalLongDeg, $geographicalLatDeg);

    descriptive_assert("[{$title}] Sunrise Hour", $localSunriseHour, $expected_localSunriseHour);
    descriptive_assert("[{$title}] Sunrise Minute", $localSunriseMinute, $expected_localSunriseMinute);
    descriptive_assert("[{$title}] Sunset Hour", $localSunsetHour, $expected_localSunsetHour);
    descriptive_assert("[{$title}] Sunset Minute", $localSunsetMinute, $expected_localSunsetMinute);
    descriptive_assert("[{$title}] Azimuth of Sunrise", $azimuthOfSunriseDeg, $expected_azimuthOfSunriseDeg);
    descriptive_assert("[{$title}] Azimuth of Sunset", $azimuthOfSunsetDeg, $expected_azimuthOfSunsetDeg);
    descriptive_assert("[{$title}] Status", $status->value, $expected_status->value);

    echo "[{$title}] PASSED\n";
}

function morning_and_evening_twilight($localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $geographicalLongDeg, $geographicalLatDeg, $twilightType, $expected_amTwilightBeginsHour, $expected_amTwilightBeginsMin, $expected_pmTwilightEndsHour, $expected_pmTwilightEndsMin, $expected_status)
{
    $title = "Morning and Evening Twilight";

    list($amTwilightBeginsHour, $amTwilightBeginsMin, $pmTwilightEndsHour, $pmTwilightEndsMin, $status) =
        PA_Sun\morning_and_evening_twilight($localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $geographicalLongDeg, $geographicalLatDeg, $twilightType);

    descriptive_assert("[{$title}] Twilight Begins Hour", $amTwilightBeginsHour, $expected_amTwilightBeginsHour);
    descriptive_assert("[{$title}] Twilight Begins Minute", $amTwilightBeginsMin, $expected_amTwilightBeginsMin);
    descriptive_assert("[{$title}] Twilight Ends Hour", $pmTwilightEndsHour, $expected_pmTwilightEndsHour);
    descriptive_assert("[{$title}] Twilight Ends Minute", $pmTwilightEndsMin, $expected_pmTwilightEndsMin);
    descriptive_assert("[{$title}] Twilight Status", $status->value, $expected_status->value);

    echo "[{$title}] PASSED\n";
}

function equation_of_time($gwdateDay, $gwdateMonth, $gwdateYear, $expected_equationOfTimeMin, $expected_equationOfTimeSec)
{
    $title = "Equation of Time";

    list($equationOfTimeMin, $equationOfTimeSec) = PA_Sun\equation_of_time($gwdateDay, $gwdateMonth, $gwdateYear);

    descriptive_assert("[{$title}] Minutes", $equationOfTimeMin, $expected_equationOfTimeMin);
    descriptive_assert("[{$title}] Seconds", $equationOfTimeSec, $expected_equationOfTimeSec);

    echo "[{$title}] PASSED\n";
}

function solar_elongation($raHour, $raMin, $raSec, $decDeg, $decMin, $decSec, $gwdateDay, $gwdateMonth, $gwdateYear, $expected_solarElongation)
{
    $title = "Solar Elongation";

    $solarElongation = PA_Sun\solar_elongation(10, 6, 45, 11, 57, 27, 27.8333333, 7, 2010);

    descriptive_assert("[{$title}]", $solarElongation, $expected_solarElongation);

    echo "[{$title}] PASSED\n";
}

approximate_position_of_sun(0, 0, 0, 27, 7, 2003, false, 0, 8, 23, 33.73, 19, 21, 14.32);

precise_position_of_sun(0, 0, 0, 27, 7, 1988, false, 0, 8, 26, 3.83, 19, 12, 49.72);

sun_distance_and_angular_size(0, 0, 0, 27, 7, 1988, false, 0, 151920130, 0, 31, 29.93);

sunrise_and_sunset(10, 3, 1986, false, -5, -71.05, 42.37, 6, 5, 17, 45, 94.83, 265.43, RiseSetStatus::OK);

morning_and_evening_twilight(7, 9, 1979, false, 0, 0, 52, TwilightType::Astronomical, 3, 17, 20, 37, TwilightStatus::OK);

equation_of_time(27, 7, 2010, 6, 31.52);

solar_elongation(10, 6, 45, 11, 57, 27, 27.8333333, 7, 2010, 24.78);
