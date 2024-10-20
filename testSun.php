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
    list($sunRAHour, $sunRAMin, $sunRASec, $sunDecDeg, $sunDecMin, $sunDecSec) = PA_Sun\approximate_position_of_sun($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection);

    descriptive_assert("[Approximate Position of Sun] RA Hour", $sunRAHour, $expectedSunRAHour);
    descriptive_assert("[Approximate Position of Sun] RA Minutes", $sunRAMin, $expectedSunRAMin);
    descriptive_assert("[Approximate Position of Sun] RA Seconds", $sunRASec, $expectedSunRASec);
    descriptive_assert("[Approximate Position of Sun] Dec Degrees", $sunDecDeg, $expectedSunDecDeg);
    descriptive_assert("[Approximate Position of Sun] Dec Minutes", $sunDecMin, $expectedSunDecMin);
    descriptive_assert("[Approximate Position of Sun] Dec Seconds", $sunDecSec, $expectedSunDecSec);

    echo "[Approximate Position of Sun] PASSED\n";
}

function precise_position_of_sun($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $expectedSunRAHour, $expectedSunRAMin, $expectedSunRASec, $expectedSunDecDeg, $expectedSunDecMin, $expectedSunDecSec)
{
    list($sunRAHour, $sunRAMin, $sunRASec, $sunDecDeg, $sunDecMin, $sunDecSec) = PA_Sun\precise_position_of_sun($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection);

    descriptive_assert("[Precise Position of Sun] RA Hour", $sunRAHour, $expectedSunRAHour);
    descriptive_assert("[Precise Position of Sun] RA Minutes", $sunRAMin, $expectedSunRAMin);
    descriptive_assert("[Precise Position of Sun] RA Seconds", $sunRASec, $expectedSunRASec);
    descriptive_assert("[Precise Position of Sun] Dec Degrees", $sunDecDeg, $expectedSunDecDeg);
    descriptive_assert("[Precise Position of Sun] Dec Minutes", $sunDecMin, $expectedSunDecMin);
    descriptive_assert("[Precise Position of Sun] Dec Seconds", $sunDecSec, $expectedSunDecSec);

    echo "[Precise Position of Sun] PASSED\n";
}

function sun_distance_and_angular_size($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $expectedSunDistKm, $expectedSunAngSizeDeg, $expectedSunAngSizeMin, $expectedSunAngSizeSec)
{
    list($sunDistKm, $sunAngSizeDeg, $sunAngSizeMin, $sunAngSizeSec) = PA_Sun\sun_distance_and_angular_size($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection);

    descriptive_assert("[Sun Distance and Angular Size] Distance km", $sunDistKm, $expectedSunDistKm);
    descriptive_assert("[Sun Distance and Angular Size] Angular Size degrees", $sunAngSizeDeg, $expectedSunAngSizeDeg);
    descriptive_assert("[Sun Distance and Angular Size] Angular Size minutes", $sunAngSizeMin, $expectedSunAngSizeMin);
    descriptive_assert("[Sun Distance and Angular Size] Angular Size seconds", $sunAngSizeSec, $expectedSunAngSizeSec);

    echo "[Sun Distance and Angular Size] PASSED\n";
}

function sunrise_and_sunset($localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $geographicalLongDeg, $geographicalLatDeg, $expected_localSunriseHour, $expected_localSunriseMinute, $expected_localSunsetHour, $expected_localSunsetMinute, $expected_azimuthOfSunriseDeg, $expected_azimuthOfSunsetDeg, $expected_status)
{
    list($localSunriseHour, $localSunriseMinute, $localSunsetHour, $localSunsetMinute, $azimuthOfSunriseDeg, $azimuthOfSunsetDeg, $status) = PA_Sun\sunrise_and_sunset($localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $geographicalLongDeg, $geographicalLatDeg);

    descriptive_assert("[Sunrise and Sunset] Sunrise Hour", $localSunriseHour, $expected_localSunriseHour);
    descriptive_assert("[Sunrise and Sunset] Sunrise Minute", $localSunriseMinute, $expected_localSunriseMinute);
    descriptive_assert("[Sunrise and Sunset] Sunset Hour", $localSunsetHour, $expected_localSunsetHour);
    descriptive_assert("[Sunrise and Sunset] Sunset Minute", $localSunsetMinute, $expected_localSunsetMinute);
    descriptive_assert("[Sunrise and Sunset] Azimuth of Sunrise", $azimuthOfSunriseDeg, $expected_azimuthOfSunriseDeg);
    descriptive_assert("[Sunrise and Sunset] Azimuth of Sunset", $azimuthOfSunsetDeg, $expected_azimuthOfSunsetDeg);
    descriptive_assert("[Sunrise and Sunset] Status", $status->value, $expected_status->value);

    echo "[Sunrise and Sunset] PASSED\n";
}

function morning_and_evening_twilight($localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $geographicalLongDeg, $geographicalLatDeg, $twilightType, $expected_amTwilightBeginsHour, $expected_amTwilightBeginsMin, $expected_pmTwilightEndsHour, $expected_pmTwilightEndsMin, $expected_status)
{
    list($amTwilightBeginsHour, $amTwilightBeginsMin, $pmTwilightEndsHour, $pmTwilightEndsMin, $status) =
        PA_Sun\morning_and_evening_twilight($localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $geographicalLongDeg, $geographicalLatDeg, $twilightType);

    descriptive_assert("Twilight Begins Hour", $amTwilightBeginsHour, $expected_amTwilightBeginsHour);
    descriptive_assert("Twilight Begins Minute", $amTwilightBeginsMin, $expected_amTwilightBeginsMin);
    descriptive_assert("Twilight Ends Hour", $pmTwilightEndsHour, $expected_pmTwilightEndsHour);
    descriptive_assert("Twilight Ends Minute", $pmTwilightEndsMin, $expected_pmTwilightEndsMin);
    descriptive_assert("Twilight Status", $status->value, $expected_status->value);

    echo "[Morning and Evening Twilight] PASSED\n";
}

approximate_position_of_sun(0, 0, 0, 27, 7, 2003, false, 0, 8, 23, 33.73, 19, 21, 14.32);

precise_position_of_sun(0, 0, 0, 27, 7, 1988, false, 0, 8, 26, 3.83, 19, 12, 49.72);

sun_distance_and_angular_size(0, 0, 0, 27, 7, 1988, false, 0, 151920130, 0, 31, 29.93);

sunrise_and_sunset(10, 3, 1986, false, -5, -71.05, 42.37, 6, 5, 17, 45, 94.83, 265.43, RiseSetStatus::OK);

morning_and_evening_twilight(7, 9, 1979, false, 0, 0, 52, TwilightType::Astronomical, 3, 17, 20, 37, TwilightStatus::OK);
