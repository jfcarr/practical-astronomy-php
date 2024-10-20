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

    assert($sunRAHour == $expectedSunRAHour);
    assert($sunRAMin == $expectedSunRAMin);
    assert($sunRASec == $expectedSunRASec);
    assert($sunDecDeg == $expectedSunDecDeg);
    assert($sunDecMin == $expectedSunDecMin);
    assert($sunDecSec == $expectedSunDecSec);

    echo "[Approximate Position] [Local Civil Time] {$lctHours}:{$lctMinutes}:{$lctSeconds} [Local Day] {$localMonth}/{$localDay}/{$localYear} = [Sun] RA {$sunRAHour}:{$sunRAMin}:{$sunRASec} Declination {$sunDecDeg} d {$sunDecMin} m {$sunDecSec} s\n";
}

function precise_position_of_sun($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $expectedSunRAHour, $expectedSunRAMin, $expectedSunRASec, $expectedSunDecDeg, $expectedSunDecMin, $expectedSunDecSec)
{
    list($sunRAHour, $sunRAMin, $sunRASec, $sunDecDeg, $sunDecMin, $sunDecSec) = PA_Sun\precise_position_of_sun($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection);

    assert($sunRAHour == $expectedSunRAHour);
    assert($sunRAMin == $expectedSunRAMin);
    assert($sunRASec == $expectedSunRASec);
    assert($sunDecDeg == $expectedSunDecDeg);
    assert($sunDecMin == $expectedSunDecMin);
    assert($sunDecSec == $expectedSunDecSec);

    echo "[Precise Position] [Local Civil Time] {$lctHours}:{$lctMinutes}:{$lctSeconds} [Local Day] {$localMonth}/{$localDay}/{$localYear} = [Sun] RA {$sunRAHour}:{$sunRAMin}:{$sunRASec} Declination {$sunDecDeg} d {$sunDecMin} m {$sunDecSec} s\n";
}

function sun_distance_and_angular_size($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $expectedSunDistKm, $expectedSunAngSizeDeg, $expectedSunAngSizeMin, $expectedSunAngSizeSec)
{
    list($sunDistKm, $sunAngSizeDeg, $sunAngSizeMin, $sunAngSizeSec) = PA_Sun\sun_distance_and_angular_size($lctHours, $lctMinutes, $lctSeconds, $localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection);

    assert($sunDistKm == $expectedSunDistKm);
    assert($sunAngSizeDeg == $expectedSunAngSizeDeg);
    assert($sunAngSizeMin == $expectedSunAngSizeMin);
    assert($sunAngSizeSec == $expectedSunAngSizeSec);

    echo "[Distance and Angular Size] [Local Time] {$lctHours}:{$lctMinutes}:{$lctSeconds} [Local Date] {$localMonth}/{$localDay}/{$localYear} = [Distance] {$sunDistKm} km [Size] {$sunAngSizeDeg} d {$sunAngSizeMin} m {$sunAngSizeSec} s\n";
}

function sunrise_and_sunset($localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $geographicalLongDeg, $geographicalLatDeg, $expected_localSunriseHour, $expected_localSunriseMinute, $expected_localSunsetHour, $expected_localSunsetMinute, $expected_azimuthOfSunriseDeg, $expected_azimuthOfSunsetDeg, $expected_status)
{
    list($localSunriseHour, $localSunriseMinute, $localSunsetHour, $localSunsetMinute, $azimuthOfSunriseDeg, $azimuthOfSunsetDeg, $status) = PA_Sun\sunrise_and_sunset($localDay, $localMonth, $localYear, $isDaylightSaving, $zoneCorrection, $geographicalLongDeg, $geographicalLatDeg);

    assert($localSunriseHour == $expected_localSunriseHour);
    assert($localSunriseMinute == $expected_localSunriseMinute);
    assert($localSunsetHour  == $expected_localSunsetHour);
    assert($localSunsetMinute  == $expected_localSunsetMinute);
    assert($azimuthOfSunriseDeg  == $expected_azimuthOfSunriseDeg);
    assert($azimuthOfSunsetDeg  == $expected_azimuthOfSunsetDeg);
    assert($status == $expected_status);

    echo "[Sunrise and Sunset] [Local Date] {$localMonth}/{$localDay}/{$localYear} [Long/Lat] {$geographicalLongDeg}/{$geographicalLatDeg} = [Sunrise Time] {$localSunriseHour}:{$localSunriseMinute} [Sunset Time] {$localSunsetHour}:{$localSunsetMinute} [Rise/Set Azimuth] {$azimuthOfSunriseDeg}/{$azimuthOfSunsetDeg} [Status] {$status->name}\n";
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
