<?php

namespace PA\Test\Coordinates;

include_once 'lib/PACoordinates.php';
include_once 'lib/PATypes.php';
include_once 'lib/PAUtils.php';

use PA\Coordinates as PA_Coord;
use PA\Types as PA_Types;

use function PA\Utils\descriptive_assert;

function angle_to_decimal_degrees($degrees, $minutes, $seconds, $expectedDecimalDegrees)
{
    $title = "Angle to Decimal Degrees";

    $decimalDegrees = round(PA_Coord\angle_to_decimal_degrees($degrees, $minutes, $seconds), 6);

    descriptive_assert("[{$title}] Decimal Degrees", $decimalDegrees, $expectedDecimalDegrees);

    echo "[{$title}] PASSED\n";
}

function decimal_degrees_to_angle($decimalDegrees, $expectedDegrees, $expectedMinutes, $expectedSeconds)
{
    $title = "Decimal Degrees to Angle";

    list($degrees, $minutes, $seconds) = PA_Coord\decimal_degrees_to_angle($decimalDegrees);

    descriptive_assert("[{$title}] Degrees", $degrees, $expectedDegrees);
    descriptive_assert("[{$title}] Minutes", $minutes, $expectedMinutes);
    descriptive_assert("[{$title}] Seconds", $seconds, $expectedSeconds);

    echo "[{$title}] PASSED\n";
}

function right_ascension_to_hour_angle($raHours, $raMinutes, $raSeconds, $lctHours, $lctMinutes, $lctSeconds, $isDaylightSavings, $zoneCorrection, $localDay, $localMonth, $localYear, $geographicalLongitude, $expectedHourAngleHours, $expectedHourAngleMinutes, $expectedHourAngleSeconds)
{
    $title = "Right Ascension to Hour Angle";

    list($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds) = PA_Coord\right_ascension_to_hour_angle($raHours, $raMinutes, $raSeconds, $lctHours, $lctMinutes, $lctSeconds, $isDaylightSavings, $zoneCorrection, $localDay, $localMonth, $localYear, $geographicalLongitude);

    descriptive_assert("[{$title}] Hour Angle Hours",  $hourAngleHours, $expectedHourAngleHours);
    descriptive_assert("[{$title}] Hour Angle Minutes",  $hourAngleMinutes, $expectedHourAngleMinutes);
    descriptive_assert("[{$title}] Hour Angle Seconds",  $hourAngleSeconds, $expectedHourAngleSeconds);

    echo "[{$title}] PASSED\n";
}

function hour_angle_to_right_ascension($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $lctHours, $lctMinutes, $lctSeconds, $isDaylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear, $geographicalLongitude, $expectedrightAscensionHours, $expectedRightAscensionMinutes, $expectedRightAscensionSeconds)
{
    $title = "Hour Angle to Right Ascension";

    list($rightAscensionHours, $rightAscensionMinutes, $rightAscensionSeconds) = PA_Coord\hour_angle_to_right_ascension($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $lctHours, $lctMinutes, $lctSeconds, $isDaylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear, $geographicalLongitude);

    descriptive_assert("[{$title}] RA Hours",  $rightAscensionHours, $expectedrightAscensionHours);
    descriptive_assert("[{$title}] RA Minutes", $rightAscensionMinutes, $expectedRightAscensionMinutes);
    descriptive_assert("[{$title}] RA Seconds", $rightAscensionSeconds, $expectedRightAscensionSeconds);

    echo "[{$title}] PASSED\n";
}

function equatorial_coordinates_to_horizon_coordinates($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $declinationDegrees, $declinationMinutes, $declinationSeconds, $geographicalLatitude, $expectedAzimuthDegrees, $expectedAzimuthMinutes, $expectedAzimuthSeconds, $expectedAltitudeDegrees, $expectedAltitudeMinutes, $expectedAltitudeSeconds)
{
    $title = "Equatorial Coordinates to Horizon Coordinates";

    list($azimuthDegrees, $azimuthMinutes, $azimuthSeconds, $altitudeDegrees, $altitudeMinutes, $altitudeSeconds) = PA_Coord\equatorial_coordinates_to_horizon_coordinates($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $declinationDegrees, $declinationMinutes, $declinationSeconds, $geographicalLatitude);

    descriptive_assert("[{$title}] Azimuth Degrees", $azimuthDegrees, $expectedAzimuthDegrees);
    descriptive_assert("[{$title}] Azimuth Minutes", $azimuthMinutes, $expectedAzimuthMinutes);
    descriptive_assert("[{$title}] Azimuth Seconds", $azimuthSeconds, $expectedAzimuthSeconds);
    descriptive_assert("[{$title}] Altitude Degrees", $altitudeDegrees, $expectedAltitudeDegrees);
    descriptive_assert("[{$title}] Altitude Minutes", $altitudeMinutes, $expectedAltitudeMinutes);
    descriptive_assert("[{$title}] Altitude Seconds", $altitudeSeconds, $expectedAltitudeSeconds);

    echo "[{$title}] PASSED\n";
}

function horizon_coordinates_to_equatorial_coordinates($azimuthDegrees, $azimuthMinutes, $azimuthSeconds, $altitudeDegrees, $altitudeMinutes, $altitudeSeconds, $geographicalLatitude, $expectedHourAngleHours, $expectedHourAngleMinutes, $expectedHourAngleSeconds, $expectedDeclinationDegrees, $expectedDeclinationMinutes, $expectedDeclinationSeconds)
{
    $title = "Horizon Coordinates to Equatorial Coordinates";

    list($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $declinationDegrees, $declinationMinutes, $declinationSeconds) = PA_Coord\horizon_coordinates_to_equatorial_coordinates($azimuthDegrees, $azimuthMinutes, $azimuthSeconds, $altitudeDegrees, $altitudeMinutes, $altitudeSeconds, $geographicalLatitude);

    descriptive_assert("[{$title}] Hour Angle Hours", $hourAngleHours, $expectedHourAngleHours);
    descriptive_assert("[{$title}] Hour Angle Minutes", $hourAngleMinutes, $expectedHourAngleMinutes);
    descriptive_assert("[{$title}] Hour Angle Seconds", $hourAngleSeconds, $expectedHourAngleSeconds);
    descriptive_assert("[{$title}] Declination Degrees", $declinationDegrees, $expectedDeclinationDegrees);
    descriptive_assert("[{$title}] Declination Minutes", $declinationMinutes, $expectedDeclinationMinutes);
    descriptive_assert("[{$title}] Declination Seconds", $declinationSeconds, $expectedDeclinationSeconds);

    echo "[{$title}] PASSED\n";
}

function mean_obliquity_of_the_ecliptic($greenwichDay, $greenwichMonth, $greenwichYear, $expectedObliquity)
{
    $title = "Mean Obliquity of the Ecliptic";

    $obliquity = round(PA_Coord\mean_obliquity_of_the_ecliptic($greenwichDay, $greenwichMonth, $greenwichYear), 8);

    descriptive_assert("[{$title}] Obliquity", $obliquity, $expectedObliquity);

    echo "[{$title}] PASSED\n";
}

function ecliptic_coordinate_to_equatorial_coordinate($eclipticLongitudeDegrees, $eclipticLongitudeMinutes, $eclipticLongitudeSeconds, $eclipticLatitudeDegrees, $eclipticLatitudeMinutes, $eclipticLatitudeSeconds, $greenwichDay, $greenwichMonth, $greenwichYear, $expectedOutRAHours, $expectedOutRAMinutes, $expectedOutRASeconds, $expectedOutDecDegrees, $expectedOutDecMinutes, $expectedOutDecSeconds)
{
    $title = "Ecliptic Coordinate to Equatorial Coordinate";

    list($outRAHours, $outRAMinutes, $outRASeconds, $outDecDegrees, $outDecMinutes, $outDecSeconds) = PA_Coord\ecliptic_coordinate_to_equatorial_coordinate($eclipticLongitudeDegrees, $eclipticLongitudeMinutes, $eclipticLongitudeSeconds, $eclipticLatitudeDegrees, $eclipticLatitudeMinutes, $eclipticLatitudeSeconds, $greenwichDay, $greenwichMonth, $greenwichYear);

    descriptive_assert("[{$title}] RA Hours", $outRAHours, $expectedOutRAHours);
    descriptive_assert("[{$title}] RA Minutes", $outRAMinutes, $expectedOutRAMinutes);
    descriptive_assert("[{$title}] RA Seconds", $outRASeconds, $expectedOutRASeconds);
    descriptive_assert("[{$title}] Declination Degrees", $outDecDegrees, $expectedOutDecDegrees);
    descriptive_assert("[{$title}] Declination Minutes", $outDecMinutes, $expectedOutDecMinutes);
    descriptive_assert("[{$title}] Declination Seconds", $outDecSeconds, $expectedOutDecSeconds);

    echo "[{$title}] PASSED\n";
}

function equatorial_coordinate_to_ecliptic_coordinate($raHours, $raMinutes, $raSeconds, $decDegrees, $decMinutes, $decSeconds, $gwDay, $gwMonth, $gwYear, $expectedOutEclLongDeg, $expectedOutEclLongMin, $expectedOutEclLongSec, $expectedOutEclLatDeg, $expectedOutEclLatMin, $expectedOutEclLatSec)
{
    $title = "Equatorial Coordinate to Ecliptic Coordinate";

    list($outEclLongDeg, $outEclLongMin, $outEclLongSec, $outEclLatDeg, $outEclLatMin, $outEclLatSec) = PA_Coord\equatorial_coordinate_to_ecliptic_coordinate($raHours, $raMinutes, $raSeconds, $decDegrees, $decMinutes, $decSeconds, $gwDay, $gwMonth, $gwYear);

    descriptive_assert("[{$title}] Ecliptic Longitude Degrees", $outEclLongDeg, $expectedOutEclLongDeg);
    descriptive_assert("[{$title}] Ecliptic Longitude Minutes", $outEclLongMin, $expectedOutEclLongMin);
    descriptive_assert("[{$title}] Ecliptic Longitude Seconds", $outEclLongSec, $expectedOutEclLongSec);
    descriptive_assert("[{$title}] Ecliptic Latitude Degrees", $outEclLatDeg, $expectedOutEclLatDeg);
    descriptive_assert("[{$title}] Ecliptic Latitude Minutes", $outEclLatMin, $expectedOutEclLatMin);
    descriptive_assert("[{$title}] Ecliptic Latitude Seconds", $outEclLatSec, $expectedOutEclLatSec);

    echo "[{$title}] PASSED\n";
}

function equatorial_coordinate_to_galactic_coordinate($raHours, $raMinutes, $raSeconds, $decDegrees, $decMinutes, $decSeconds, $expectedGalLongDeg, $expectedGalLongMin, $expectedGalLongSec, $expectedGalLatDeg, $expectedGalLatMin, $expectedGalLatSec)
{
    $title = "Equatorial Coordinate to Galactic Coordinate";

    list($galLongDeg, $galLongMin, $galLongSec, $galLatDeg, $galLatMin, $galLatSec) = PA_Coord\equatorial_coordinate_to_galactic_coordinate($raHours, $raMinutes, $raSeconds, $decDegrees, $decMinutes, $decSeconds);

    descriptive_assert("[{$title}] Galactic Longitude Degrees", $galLongDeg, $expectedGalLongDeg);
    descriptive_assert("[{$title}] Galactic Longitude Minutes", $galLongMin, $expectedGalLongMin);
    descriptive_assert("[{$title}] Galactic Longitude Seconds", $galLongSec, $expectedGalLongSec);
    descriptive_assert("[{$title}] Galactic Latitude Degrees", $galLatDeg, $expectedGalLatDeg);
    descriptive_assert("[{$title}] Galactic Latitude Minutes", $galLatMin, $expectedGalLatMin);
    descriptive_assert("[{$title}] Galactic Latitude Seconds", $galLatSec, $expectedGalLatSec);

    echo "[{$title}] PASSED\n";
}

function galactic_coordinate_to_equatorial_coordinate($galLongDeg, $galLongMin, $galLongSec, $galLatDeg, $galLatMin, $galLatSec, $expectedRaHours, $expectedRaMinutes, $expectedRaSeconds, $expectedDecDegrees, $expectedDecMinutes, $expectedDecSeconds)
{
    $title = "Galactic Coordinate to Equatorial Coordinate";

    list($raHours, $raMinutes, $raSeconds, $decDegrees, $decMinutes, $decSeconds) = PA_Coord\galactic_coordinate_to_equatorial_coordinate($galLongDeg, $galLongMin, $galLongSec, $galLatDeg, $galLatMin, $galLatSec);

    descriptive_assert("[{$title}] RA Hours", $raHours, $expectedRaHours);
    descriptive_assert("[{$title}] RA Minutes", $raMinutes, $expectedRaMinutes);
    descriptive_assert("[{$title}] RA Seconds", $raSeconds, $expectedRaSeconds);
    descriptive_assert("[{$title}] Declination Degrees", $decDegrees, $expectedDecDegrees);
    descriptive_assert("[{$title}] Declination Minutes", $decMinutes, $expectedDecMinutes);
    descriptive_assert("[{$title}] Declination Seconds", $decSeconds, $expectedDecSeconds);

    echo "[{$title}] PASSED\n";
}

function angle_between_two_objects($raLong1HourDeg, $raLong1Min, $raLong1Sec, $decLat1Deg, $decLat1Min, $decLat1Sec, $raLong2HourDeg, $raLong2Min, $raLong2Sec, $decLat2Deg, $decLat2Min, $decLat2Sec, PA_Types\AngleMeasure $hourOrDegree, $expectedAngleDeg, $expectedAngleMin, $expectedAngleSec)
{
    $title = "Angle Between Two Objects";

    list($angleDeg, $angleMin, $angleSec) = PA_Coord\angle_between_two_objects($raLong1HourDeg, $raLong1Min, $raLong1Sec, $decLat1Deg, $decLat1Min, $decLat1Sec, $raLong2HourDeg, $raLong2Min, $raLong2Sec, $decLat2Deg, $decLat2Min, $decLat2Sec, $hourOrDegree);

    descriptive_assert("[{$title}] Angle Degrees", $angleDeg, $expectedAngleDeg);
    descriptive_assert("[{$title}] Angle Minutes", $angleMin, $expectedAngleMin);
    descriptive_assert("[{$title}] Angle Seconds", $angleSec, $expectedAngleSec);

    echo "[{$title}] PASSED\n";
}

function rising_and_setting($raHours, $raMinutes, $raSeconds, $decDeg, $decMin, $decSec, $gwDateDay, $gwDateMonth, $gwDateYear, $geogLongDeg, $geogLatDeg, $vertShiftDeg, $expectedRiseSetStatus, $expectedUtRiseHour, $expectedUtRiseMin, $expectedUtSetHour, $expectedUtSetMin, $expectedAzRise, $expectedAzSet)
{
    $title = "Rising and Setting";

    list($riseSetStatus, $utRiseHour, $utRiseMin, $utSetHour, $utSetMin, $azRise, $azSet) = PA_Coord\rising_and_setting($raHours, $raMinutes, $raSeconds, $decDeg, $decMin, $decSec, $gwDateDay, $gwDateMonth, $gwDateYear, $geogLongDeg, $geogLatDeg, $vertShiftDeg);

    descriptive_assert("[{$title}] Rise/Set Status", $riseSetStatus->value, $expectedRiseSetStatus->value);
    descriptive_assert("[{$title}] UT Rise Hour", $utRiseHour, $expectedUtRiseHour);
    descriptive_assert("[{$title}] UT Rise Minutes", $utRiseMin, $expectedUtRiseMin);
    descriptive_assert("[{$title}] UT Set Hour", $utSetHour, $expectedUtSetHour);
    descriptive_assert("[{$title}] UT Set Minutes", $utSetMin, $expectedUtSetMin);
    descriptive_assert("[{$title}] Azimuth Rise", $azRise, $expectedAzRise);
    descriptive_assert("[{$title}] Azimuth Set", $azSet, $expectedAzSet);

    echo "[{$title}] PASSED\n";
}

function correct_for_precession($raHour, $raMinutes, $raSeconds, $decDeg, $decMinutes, $decSeconds, $epoch1Day, $epoch1Month, $epoch1Year, $epoch2Day, $epoch2Month, $epoch2Year, $expectedCorrectedRAHour, $expectedCorrectedRAMinutes, $expectedCorrectedRASeconds, $expectedCorrectedDecDeg, $expectedCorrectedDecMinutes, $expectedCorrectedDecSeconds)
{
    $title = "Correct for Precession";

    list($correctedRAHour, $correctedRAMinutes, $correctedRASeconds, $correctedDecDeg, $correctedDecMinutes, $correctedDecSeconds) = PA_Coord\correct_for_precession($raHour, $raMinutes, $raSeconds, $decDeg, $decMinutes, $decSeconds, $epoch1Day, $epoch1Month, $epoch1Year, $epoch2Day, $epoch2Month, $epoch2Year);

    descriptive_assert("[{$title}] Corrected RA Hour", $correctedRAHour, $expectedCorrectedRAHour);
    descriptive_assert("[{$title}] Corrected RA Minutes", $correctedRAMinutes, $expectedCorrectedRAMinutes);
    descriptive_assert("[{$title}] Corrected RA Seconds", $correctedRASeconds, $expectedCorrectedRASeconds);
    descriptive_assert("[{$title}] Corrected Declination Degrees", $correctedDecDeg, $expectedCorrectedDecDeg);
    descriptive_assert("[{$title}] Corrected Declination Minutes", $correctedDecMinutes, $expectedCorrectedDecMinutes);
    descriptive_assert("[{$title}] Corrected Declination Seconds", $correctedDecSeconds, $expectedCorrectedDecSeconds);

    echo "[{$title}] PASSED\n";
}

function nutation_in_ecliptic_longitude_and_obliquity($greenwichDay, $greenwichMonth, $greenwichYear, $expectedNutInLongDeg, $expectedNutInOblDeg)
{
    $title = "Nutation in Ecliptic Longitude and Obliquity";

    list($nutInLongDeg, $nutInOblDeg) = PA_Coord\nutation_in_ecliptic_longitude_and_obliquity($greenwichDay, $greenwichMonth, $greenwichYear, $expectedNutInLongDeg, $expectedNutInOblDeg);

    descriptive_assert("[{$title}] Nuation in Longitude Degrees", round($nutInLongDeg, 9), $expectedNutInLongDeg);
    descriptive_assert("[{$title}] Nuation in Obliquity Degrees", round($nutInOblDeg, 7), $expectedNutInOblDeg);

    echo "[{$title}] PASSED\n";
}

function correct_for_aberration($utHour, $utMinutes, $utSeconds, $gwDay, $gwMonth, $gwYear, $trueEclLongDeg, $trueEclLongMin, $trueEclLongSec, $trueEclLatDeg, $trueEclLatMin, $trueEclLatSec, $expectedApparentEclLongDeg, $expectedApparentEclLongMin, $expectedApparentEclLongSec, $expectedApparentEclLatDeg, $expectedApparentEclLatMin, $expectedApparentEclLatSec)
{
    $title = "Correct for Aberration";

    list($apparentEclLongDeg, $apparentEclLongMin, $apparentEclLongSec, $apparentEclLatDeg, $apparentEclLatMin, $apparentEclLatSec) = PA_Coord\correct_for_aberration($utHour, $utMinutes, $utSeconds, $gwDay, $gwMonth, $gwYear, $trueEclLongDeg, $trueEclLongMin, $trueEclLongSec, $trueEclLatDeg, $trueEclLatMin, $trueEclLatSec);

    descriptive_assert("[{$title}] Apparent Ecliptic Longitude Degrees", $apparentEclLongDeg, $expectedApparentEclLongDeg);
    descriptive_assert("[{$title}] Apparent Ecliptic Longitude Minutes", $apparentEclLongMin, $expectedApparentEclLongMin);
    descriptive_assert("[{$title}] Apparent Ecliptic Longitude Seconds", $apparentEclLongSec, $expectedApparentEclLongSec);
    descriptive_assert("[{$title}] Apparent Ecliptic Latitude Degrees", $apparentEclLatDeg, $expectedApparentEclLatDeg);
    descriptive_assert("[{$title}] Apparent Ecliptic Latitude Minutes", $apparentEclLatMin, $expectedApparentEclLatMin);
    descriptive_assert("[{$title}] Apparent Ecliptic Latitude Seconds", $apparentEclLatSec, $expectedApparentEclLatSec);

    echo "[{$title}] PASSED\n";
}

function atmospheric_refraction($trueRAHour, $trueRAMin, $trueRASec, $trueDecDeg, $trueDecMin, $trueDecSec, PA_Types\CoordinateType $coordinateType, $geogLongDeg, $geogLatDeg, $daylightSavingHours, $timezoneHours, $lcdDay, $lcdMonth, $lcdYear, $lctHour, $lctMin, $lctSec, $atmosphericPressureMbar, $atmosphericTemperatureCelsius, $expectedCorrectedRAHour, $expectedCorrectedRAMin, $expectedCorrectedRASec, $expectedCorrectedDecDeg, $expectedCorrectedDecMin, $expectedCorrectedDecSec)
{
    $title = "Atmospheric Refraction";

    list($correctedRAHour, $correctedRAMin, $correctedRASec, $correctedDecDeg, $correctedDecMin, $correctedDecSec) = PA_Coord\atmospheric_refraction($trueRAHour, $trueRAMin, $trueRASec, $trueDecDeg, $trueDecMin, $trueDecSec, $coordinateType, $geogLongDeg, $geogLatDeg, $daylightSavingHours, $timezoneHours, $lcdDay, $lcdMonth, $lcdYear, $lctHour, $lctMin, $lctSec, $atmosphericPressureMbar, $atmosphericTemperatureCelsius);

    descriptive_assert("[{$title}] Corrected RA Hour", $correctedRAHour, $expectedCorrectedRAHour);
    descriptive_assert("[{$title}] Corrected RA Minutes", $correctedRAMin, $expectedCorrectedRAMin);
    descriptive_assert("[{$title}] Corrected RA Seconds", $correctedRASec, $expectedCorrectedRASec);
    descriptive_assert("[{$title}] Corrected Declination Degrees", $correctedDecDeg, $expectedCorrectedDecDeg);
    descriptive_assert("[{$title}] Corrected Declination Minutes", $correctedDecMin, $expectedCorrectedDecMin);
    descriptive_assert("[{$title}] Corrected Declination Seconds", $correctedDecSec, $expectedCorrectedDecSec);

    echo "[{$title}] PASSED\n";
}

function corrections_for_geocentric_parallax($raHour, $raMin, $raSec, $decDeg, $decMin, $decSec, PA_Types\CoordinateType $coordinateType, $equatorialHorParallaxDeg, $geogLongDeg, $geogLatDeg, $heightM, $daylightSaving, $timezoneHours, $lcdDay, $lcdMonth, $lcdYear, $lctHour, $lctMin, $lctSec, $expectedCorrectedRAHour, $expectedCorrectedRAMin, $expectedCorrectedRASec, $expectedCorrectedDecDeg, $expectedCorrectedDecMin, $expectedCorrectedDecSec)
{
    $title = "Corrections for Geocentric Parallax";

    list($correctedRAHour, $correctedRAMin, $correctedRASec, $correctedDecDeg, $correctedDecMin, $correctedDecSec) = PA_Coord\corrections_for_geocentric_parallax($raHour, $raMin, $raSec, $decDeg, $decMin, $decSec, $coordinateType, $equatorialHorParallaxDeg, $geogLongDeg, $geogLatDeg, $heightM, $daylightSaving, $timezoneHours, $lcdDay, $lcdMonth, $lcdYear, $lctHour, $lctMin, $lctSec);

    descriptive_assert("[{$title}] Corrected RA Hour", $correctedRAHour, $expectedCorrectedRAHour);
    descriptive_assert("[{$title}] Corrected RA Minutes", $correctedRAMin, $expectedCorrectedRAMin);
    descriptive_assert("[{$title}] Corrected RA Seconds", $correctedRASec, $expectedCorrectedRASec);
    descriptive_assert("[{$title}] Corrected Declination Hour", $correctedDecDeg, $expectedCorrectedDecDeg);
    descriptive_assert("[{$title}] Corrected Declination Minutes", $correctedDecMin, $expectedCorrectedDecMin);
    descriptive_assert("[{$title}] Corrected Declination Seconds", $correctedDecSec, $expectedCorrectedDecSec);

    echo "[{$title}] PASSED\n";
}

function heliographic_coordinates($helioPositionAngleDeg, $helioDisplacementArcmin, $gwdateDay, $gwdateMonth, $gwdateYear, $expectedHelioLongDeg, $expectedHelioLatDeg)
{
    $title = "Heliographic Coordinates";

    list($helioLongDeg, $helioLatDeg) = PA_Coord\heliographic_coordinates($helioPositionAngleDeg, $helioDisplacementArcmin, $gwdateDay, $gwdateMonth, $gwdateYear);

    descriptive_assert("[{$title}] Heliographic Longitude Degrees", $helioLongDeg, $expectedHelioLongDeg);
    descriptive_assert("[{$title}] Heliographic Latitude Degrees", $helioLatDeg, $expectedHelioLatDeg);

    echo "[{$title}] PASSED\n";
}

function carrington_rotation_number($gwdateDay, $gwdateMonth, $gwdateYear, $expectedCrn)
{
    $title = "Carrington Rotation Number";

    $crn = PA_Coord\carrington_rotation_number($gwdateDay, $gwdateMonth, $gwdateYear);

    descriptive_assert("[{$title}] Carrington Rotation Number", $crn, $expectedCrn);

    echo "[{$title}] PASSED\n";
}

function selenographic_coordinates1($gwdateDay, $gwdateMonth, $gwdateYear, $expectedSubEarthLongitude, $expectedSubEarthLatitude, $expectedPositionAngleOfPole)
{
    $title = "Selenograpic Coordinates 1";

    list($subEarthLongitude, $subEarthLatitude, $positionAngleOfPole) = PA_Coord\selenographic_coordinates1($gwdateDay, $gwdateMonth, $gwdateYear);

    descriptive_assert("[{$title}] Sub-Earth Longitude", $subEarthLongitude, $expectedSubEarthLongitude);
    descriptive_assert("[{$title}] Sub-Earth Latitude", $subEarthLatitude, $expectedSubEarthLatitude);
    descriptive_assert("[{$title}] Position Angle of Pole", $positionAngleOfPole, $expectedPositionAngleOfPole);

    echo "[{$title}] PASSED\n";
}

function selenographic_coordinates2($gwdateDay, $gwdateMonth, $gwdateYear, $expectedSubSolarLongitude, $expectedSubSolarColongitude, $expectedSubSolarLatitude)
{
    $title = "Selenograpic Coordinates 2";

    list($subSolarLongitude, $subSolarColongitude, $subSolarLatitude) = PA_Coord\selenographic_coordinates2($gwdateDay, $gwdateMonth, $gwdateYear);

    descriptive_assert("[{$title}] Sub-Solar Longitude", $subSolarLongitude, $expectedSubSolarLongitude);
    descriptive_assert("[{$title}] Sub-Solar Co-Longitude", $subSolarColongitude, $expectedSubSolarColongitude);
    descriptive_assert("[{$title}] Sub-Solar Latitude", $subSolarLatitude, $expectedSubSolarLatitude);

    echo "[{$title}] PASSED\n";
}

angle_to_decimal_degrees(182, 31, 27, 182.524167);

decimal_degrees_to_angle(182.524167, 182, 31, 27);

right_ascension_to_hour_angle(18, 32, 21, 14, 36, 51.67, false, -4, 22, 4, 1980, -64, 9, 52, 23.66);

hour_angle_to_right_ascension(9, 52, 23.66, 14, 36, 51.67, false, -4, 22, 4, 1980, -64, 18, 32, 21);

equatorial_coordinates_to_horizon_coordinates(5, 51, 44, 23, 13, 10, 52, 283, 16, 15.7, 19, 20, 3.64);

horizon_coordinates_to_equatorial_coordinates(283, 16, 15.7, 19, 20, 3.64, 52, 5, 51, 44, 23, 13, 10);

mean_obliquity_of_the_ecliptic(6, 7, 2009, 23.43805531);

ecliptic_coordinate_to_equatorial_coordinate(139, 41, 10, 4, 52, 31, 6, 7, 2009, 9, 34, 53.4, 19, 32, 8.52);

equatorial_coordinate_to_ecliptic_coordinate(9, 34, 53.4, 19, 32, 8.52, 6, 7, 2009, 139, 41, 9.97, 4, 52, 30.99);

equatorial_coordinate_to_galactic_coordinate(10, 21, 0, 10, 3, 11, 232, 14, 52.38, 51, 7, 20.16);

galactic_coordinate_to_equatorial_coordinate(232, 14, 52.38, 51, 7, 20.16, 10, 21, 0, 10, 3, 11);

angle_between_two_objects(5, 13, 31.7, -8, 13, 30, 6, 44, 13.4, -16, 41, 11, PA_Types\AngleMeasure::Hours, 23, 40, 25.86);

rising_and_setting(23, 39, 20, 21, 42, 0, 24, 8, 2010, 64, 30, 0.5667, PA_Types\RiseSetStatus::OK, 14, 16, 4, 10, 64.36, 295.64);

correct_for_precession(9, 10, 43, 14, 23, 25, 0.923, 1, 1950, 1, 6, 1979, 9, 12, 20.18, 14, 16, 9.12);

nutation_in_ecliptic_longitude_and_obliquity(1, 9, 1988, 0.001525808, 0.0025671);

correct_for_aberration(0, 0, 0, 8, 9, 1988, 352, 37, 10.1, -1, 32, 56.4, 352, 37, 30.45, -1, 32, 56.33);

atmospheric_refraction(23, 14, 0, 40, 10, 0, PA_Types\CoordinateType::True, 0.17, 51.2036110, 0, 0, 23, 3, 1987, 1, 1, 24, 1012, 21.7, 23, 13, 44.74, 40, 19, 45.76);

corrections_for_geocentric_parallax(22, 35, 19, -7, 41, 13, PA_Types\CoordinateType::True, 1.019167, -100, 50, 60, 0, -6, 26, 2, 1979, 10, 45, 0, 22, 36, 43.22, -8, 32, 17.4);

heliographic_coordinates(220, 10.5, 1, 5, 1988, 142.59, -19.94);

carrington_rotation_number(27, 1, 1975, 1624);

selenographic_coordinates1(1, 5, 1988, -4.88, 4.04, 19.78);

selenographic_coordinates2(1, 5, 1988, 6.81, 83.19, 1.19);
