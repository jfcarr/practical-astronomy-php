<?php

namespace PA\Test\Coordinates;

include_once 'lib/PACoordinates.php';
include_once 'lib/PATypes.php';

use PA\Coordinates as PA_Coord;
use PA\Types as PA_Types;

function angle_to_decimal_degrees($degrees, $minutes, $seconds, $expectedDecimalDegrees)
{
    $decimalDegrees = round(PA_Coord\angle_to_decimal_degrees($degrees, $minutes, $seconds), 6);

    assert($decimalDegrees  == $expectedDecimalDegrees);

    echo "[Angle] {$degrees} degrees, {$minutes} minutes {$seconds} seconds = [Decimal Degrees] {$decimalDegrees} degrees\n";
}

function decimal_degrees_to_angle($decimalDegrees, $expectedDegrees, $expectedMinutes, $expectedSeconds)
{
    list($degrees, $minutes, $seconds) = PA_Coord\decimal_degrees_to_angle($decimalDegrees);

    assert($degrees == $expectedDegrees);
    assert($minutes == $expectedMinutes);
    assert($seconds == $expectedSeconds);

    echo "[Decimal Degrees] {$decimalDegrees} = [Angle] {$degrees} degrees, {$minutes} minutes {$seconds} seconds\n";
}

function right_ascension_to_hour_angle($raHours, $raMinutes, $raSeconds, $lctHours, $lctMinutes, $lctSeconds, $isDaylightSavings, $zoneCorrection, $localDay, $localMonth, $localYear, $geographicalLongitude, $expectedHourAngleHours, $expectedHourAngleMinutes, $expectedHourAngleSeconds)
{
    list($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds) = PA_Coord\right_ascension_to_hour_angle($raHours, $raMinutes, $raSeconds, $lctHours, $lctMinutes, $lctSeconds, $isDaylightSavings, $zoneCorrection, $localDay, $localMonth, $localYear, $geographicalLongitude);

    assert($hourAngleHours == $expectedHourAngleHours);
    assert($hourAngleMinutes == $expectedHourAngleMinutes);
    assert($hourAngleSeconds == $expectedHourAngleSeconds);

    echo "[Right Ascension] RA {$raHours}:{$raMinutes}:{$raSeconds} LCT {$lctHours}:{$lctMinutes}:{$lctSeconds} = [Hour Angle] {$hourAngleHours}:{$hourAngleMinutes}:{$hourAngleSeconds}\n";
}

function hour_angle_to_right_ascension($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $lctHours, $lctMinutes, $lctSeconds, $isDaylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear, $geographicalLongitude, $expectedrightAscensionHours, $expectedRightAscensionMinutes, $expectedRightAscensionSeconds)
{
    list($rightAscensionHours, $rightAscensionMinutes, $rightAscensionSeconds) = PA_Coord\hour_angle_to_right_ascension($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $lctHours, $lctMinutes, $lctSeconds, $isDaylightSaving, $zoneCorrection, $localDay, $localMonth, $localYear, $geographicalLongitude);

    assert($rightAscensionHours == $expectedrightAscensionHours);
    assert($rightAscensionMinutes == $expectedRightAscensionMinutes);
    assert($rightAscensionSeconds == $expectedRightAscensionSeconds);

    echo "[Hour Angle] HA {$hourAngleHours}:{$hourAngleMinutes}:{$hourAngleSeconds} LCT {$lctHours}:{$lctMinutes}:{$lctSeconds} = [Right Ascension] {$rightAscensionHours}:{$rightAscensionMinutes}:{$rightAscensionSeconds} \n";
}

function equatorial_coordinates_to_horizon_coordinates($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $declinationDegrees, $declinationMinutes, $declinationSeconds, $geographicalLatitude, $expectedAzimuthDegrees, $expectedAzimuthMinutes, $expectedAzimuthSeconds, $expectedAltitudeDegrees, $expectedAltitudeMinutes, $expectedAltitudeSeconds)
{
    list($azimuthDegrees, $azimuthMinutes, $azimuthSeconds, $altitudeDegrees, $altitudeMinutes, $altitudeSeconds) = PA_Coord\equatorial_coordinates_to_horizon_coordinates($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $declinationDegrees, $declinationMinutes, $declinationSeconds, $geographicalLatitude);

    assert($azimuthDegrees == $expectedAzimuthDegrees);
    assert($azimuthMinutes == $expectedAzimuthMinutes);
    assert($azimuthSeconds == $expectedAzimuthSeconds);
    assert($altitudeDegrees == $expectedAltitudeDegrees);
    assert($altitudeMinutes == $expectedAltitudeMinutes);
    assert($altitudeSeconds == $expectedAltitudeSeconds);

    echo "[Equatorial Coord] HA {$hourAngleHours}:{$hourAngleMinutes}:{$hourAngleSeconds} Declination {$declinationDegrees} d {$declinationMinutes} m {$declinationSeconds} s == [Horizon Coord] Azimuth {$azimuthDegrees} d {$azimuthMinutes} m {$azimuthSeconds} s, Altitude {$altitudeDegrees} d {$altitudeMinutes} m {$altitudeSeconds} s\n";
}

function horizon_coordinates_to_equatorial_coordinates($azimuthDegrees, $azimuthMinutes, $azimuthSeconds, $altitudeDegrees, $altitudeMinutes, $altitudeSeconds, $geographicalLatitude, $expectedHourAngleHours, $expectedHourAngleMinutes, $expectedHourAngleSeconds, $expectedDeclinationDegrees, $expectedDeclinationMinutes, $expectedDeclinationSeconds)
{
    list($hourAngleHours, $hourAngleMinutes, $hourAngleSeconds, $declinationDegrees, $declinationMinutes, $declinationSeconds) = PA_Coord\horizon_coordinates_to_equatorial_coordinates($azimuthDegrees, $azimuthMinutes, $azimuthSeconds, $altitudeDegrees, $altitudeMinutes, $altitudeSeconds, $geographicalLatitude);

    assert($hourAngleHours == $expectedHourAngleHours);
    assert($hourAngleMinutes == $expectedHourAngleMinutes);
    assert($hourAngleSeconds == $expectedHourAngleSeconds);
    assert($declinationDegrees == $expectedDeclinationDegrees);
    assert($declinationMinutes == $expectedDeclinationMinutes);
    assert($declinationSeconds == $expectedDeclinationSeconds);

    echo "[Horizon Coord] Azimuth {$azimuthDegrees} d {$azimuthMinutes} m {$azimuthSeconds} s, Altitude {$altitudeDegrees} d {$altitudeMinutes} m {$altitudeSeconds} s == [Equatorial Coord] HA {$hourAngleHours}:{$hourAngleMinutes}:{$hourAngleSeconds} Declination {$declinationDegrees} d {$declinationMinutes} m {$declinationSeconds} s\n";
}

function mean_obliquity_of_the_ecliptic($greenwichDay, $greenwichMonth, $greenwichYear, $expectedObliquity)
{
    $obliquity = round(PA_Coord\mean_obliquity_of_the_ecliptic($greenwichDay, $greenwichMonth, $greenwichYear), 8);

    assert($obliquity == $expectedObliquity);

    echo "[Greenwich Date] {$greenwichMonth}/{$greenwichDay}/{$greenwichYear} = [Obliquity] {$obliquity}\n";
}

function ecliptic_coordinate_to_equatorial_coordinate($eclipticLongitudeDegrees, $eclipticLongitudeMinutes, $eclipticLongitudeSeconds, $eclipticLatitudeDegrees, $eclipticLatitudeMinutes, $eclipticLatitudeSeconds, $greenwichDay, $greenwichMonth, $greenwichYear, $expectedOutRAHours, $expectedOutRAMinutes, $expectedOutRASeconds, $expectedOutDecDegrees, $expectedOutDecMinutes, $expectedOutDecSeconds)
{
    list($outRAHours, $outRAMinutes, $outRASeconds, $outDecDegrees, $outDecMinutes, $outDecSeconds) = PA_Coord\ecliptic_coordinate_to_equatorial_coordinate($eclipticLongitudeDegrees, $eclipticLongitudeMinutes, $eclipticLongitudeSeconds, $eclipticLatitudeDegrees, $eclipticLatitudeMinutes, $eclipticLatitudeSeconds, $greenwichDay, $greenwichMonth, $greenwichYear);

    assert($outRAHours == $expectedOutRAHours);
    assert($outRAMinutes == $expectedOutRAMinutes);
    assert($outRASeconds == $expectedOutRASeconds);
    assert($outDecDegrees == $expectedOutDecDegrees);
    assert($outDecMinutes == $expectedOutDecMinutes);
    assert($outDecSeconds == $expectedOutDecSeconds);

    echo "[Ecliptic] Longitude {$eclipticLongitudeDegrees} d {$eclipticLongitudeMinutes} m {$eclipticLongitudeSeconds} s, Latitude {$eclipticLatitudeDegrees} d {$eclipticLatitudeMinutes} m {$eclipticLatitudeSeconds} s = [Equatorial] RA {$outRAHours} h {$outRAMinutes} m {$outRASeconds} s, Dec {$outDecDegrees} d {$outDecMinutes} m {$outDecSeconds} s\n";
}

function equatorial_coordinate_to_ecliptic_coordinate($raHours, $raMinutes, $raSeconds, $decDegrees, $decMinutes, $decSeconds, $gwDay, $gwMonth, $gwYear, $expectedOutEclLongDeg, $expectedOutEclLongMin, $expectedOutEclLongSec, $expectedOutEclLatDeg, $expectedOutEclLatMin, $expectedOutEclLatSec)
{
    list($outEclLongDeg, $outEclLongMin, $outEclLongSec, $outEclLatDeg, $outEclLatMin, $outEclLatSec) = PA_Coord\equatorial_coordinate_to_ecliptic_coordinate($raHours, $raMinutes, $raSeconds, $decDegrees, $decMinutes, $decSeconds, $gwDay, $gwMonth, $gwYear);

    assert($outEclLongDeg == $expectedOutEclLongDeg);
    assert($outEclLongMin == $expectedOutEclLongMin);
    assert($outEclLongSec == $expectedOutEclLongSec);
    assert($outEclLatDeg == $expectedOutEclLatDeg);
    assert($outEclLatMin == $expectedOutEclLatMin);
    assert($outEclLatSec == $expectedOutEclLatSec);

    echo "[Equatorial] RA {$raHours} h {$raMinutes} m {$raSeconds}, Declination {$decDegrees} d {$decMinutes} m {$decSeconds} s = [Ecliptic] Longitude {$outEclLongDeg} d {$outEclLongMin} m {$outEclLongSec} s, Latitude {$outEclLatDeg} d {$outEclLatMin} m {$outEclLatSec} s\n";
}

function equatorial_coordinate_to_galactic_coordinate($raHours, $raMinutes, $raSeconds, $decDegrees, $decMinutes, $decSeconds, $expectedGalLongDeg, $expectedGalLongMin, $expectedGalLongSec, $expectedGalLatDeg, $expectedGalLatMin, $expectedGalLatSec)
{
    list($galLongDeg, $galLongMin, $galLongSec, $galLatDeg, $galLatMin, $galLatSec) = PA_Coord\equatorial_coordinate_to_galactic_coordinate($raHours, $raMinutes, $raSeconds, $decDegrees, $decMinutes, $decSeconds);

    assert($galLongDeg == $expectedGalLongDeg);
    assert($galLongMin == $expectedGalLongMin);
    assert($galLongSec = $expectedGalLongSec);
    assert($galLatDeg == $expectedGalLatDeg);
    assert($galLatMin == $expectedGalLatMin);
    assert($galLatSec == $expectedGalLatSec);

    echo "[Equatorial] RA {$raHours} h {$raMinutes} m {$raSeconds}, Declination {$decDegrees} d {$decMinutes} m {$decSeconds} s = [Galactic] Longitude {$galLongDeg} d {$galLongMin} m {$galLongSec} s, Latitude {$galLatDeg} d {$galLatMin} m {$galLatSec} s\n";
}

function galactic_coordinate_to_equatorial_coordinate($galLongDeg, $galLongMin, $galLongSec, $galLatDeg, $galLatMin, $galLatSec, $expectedRaHours, $expectedRaMinutes, $expectedRaSeconds, $expectedDecDegrees, $expectedDecMinutes, $expectedDecSeconds)
{
    list($raHours, $raMinutes, $raSeconds, $decDegrees, $decMinutes, $decSeconds) = PA_Coord\galactic_coordinate_to_equatorial_coordinate($galLongDeg, $galLongMin, $galLongSec, $galLatDeg, $galLatMin, $galLatSec);

    assert($raHours == $expectedRaHours);
    assert($raMinutes == $expectedRaMinutes);
    assert($raSeconds == $expectedRaSeconds);
    assert($decDegrees == $expectedDecDegrees);
    assert($decMinutes == $expectedDecMinutes);
    assert($decSeconds == $expectedDecSeconds);

    echo "[Galactic] Longitude {$galLongDeg} d {$galLongMin} m {$galLongSec} s, Latitude {$galLatDeg} d {$galLatMin} m {$galLatSec} s = [Equatorial] RA {$raHours}:{$raMinutes}:{$raSeconds}, Declination {$decDegrees} d {$decMinutes} m {$decSeconds} s\n";
}

function angle_between_two_objects($raLong1HourDeg, $raLong1Min, $raLong1Sec, $decLat1Deg, $decLat1Min, $decLat1Sec, $raLong2HourDeg, $raLong2Min, $raLong2Sec, $decLat2Deg, $decLat2Min, $decLat2Sec, PA_Types\AngleMeasure $hourOrDegree, $expectedAngleDeg, $expectedAngleMin, $expectedAngleSec)
{
    list($angleDeg, $angleMin, $angleSec) = PA_Coord\angle_between_two_objects($raLong1HourDeg, $raLong1Min, $raLong1Sec, $decLat1Deg, $decLat1Min, $decLat1Sec, $raLong2HourDeg, $raLong2Min, $raLong2Sec, $decLat2Deg, $decLat2Min, $decLat2Sec, $hourOrDegree);

    assert($angleDeg == $expectedAngleDeg);
    assert($angleMin == $expectedAngleMin);
    assert($angleSec == $expectedAngleSec);

    echo "[Object 1] RA/Longitude {$raLong1HourDeg} d {$raLong1Min} m {$raLong1Sec} s, Declination/Latitude {$decLat1Deg} d {$decLat1Min} m {$decLat1Sec} s [Object 2] RA/Longitude {$raLong2HourDeg} d {$raLong2Min} m {$raLong2Sec} s, Declination/Latitude {$decLat2Deg} d {$decLat2Min} m {$decLat2Sec} s = [Angle] {$angleDeg} d {$angleMin} m {$angleSec} s\n";
}

function rising_and_setting($raHours, $raMinutes, $raSeconds, $decDeg, $decMin, $decSec, $gwDateDay, $gwDateMonth, $gwDateYear, $geogLongDeg, $geogLatDeg, $vertShiftDeg, $expectedRiseSetStatus, $expectedUtRiseHour, $expectedUtRiseMin, $expectedUtSetHour, $expectedUtSetMin, $expectedAzRise, $expectedAzSet)
{
    list($riseSetStatus, $utRiseHour, $utRiseMin, $utSetHour, $utSetMin, $azRise, $azSet) = PA_Coord\rising_and_setting($raHours, $raMinutes, $raSeconds, $decDeg, $decMin, $decSec, $gwDateDay, $gwDateMonth, $gwDateYear, $geogLongDeg, $geogLatDeg, $vertShiftDeg);

    assert($riseSetStatus == $expectedRiseSetStatus);
    assert($utRiseHour == $expectedUtRiseHour);
    assert($utRiseMin == $expectedUtRiseMin);
    assert($utSetHour == $expectedUtSetHour);
    assert($utSetMin == $expectedUtSetMin);
    assert($azRise == $expectedAzRise);
    assert($azSet == $expectedAzSet);

    echo "[Rise/Set] status {$riseSetStatus->value} UT Rise {$utRiseHour}:{$utRiseMin} UT Set {$utSetHour}:{$utSetMin} AZ Rise/Set {$azRise}/{$azSet}\n";
}

function correct_for_precession($raHour, $raMinutes, $raSeconds, $decDeg, $decMinutes, $decSeconds, $epoch1Day, $epoch1Month, $epoch1Year, $epoch2Day, $epoch2Month, $epoch2Year, $expectedCorrectedRAHour, $expectedCorrectedRAMinutes, $expectedCorrectedRASeconds, $expectedCorrectedDecDeg, $expectedCorrectedDecMinutes, $expectedCorrectedDecSeconds)
{
    list($correctedRAHour, $correctedRAMinutes, $correctedRASeconds, $correctedDecDeg, $correctedDecMinutes, $correctedDecSeconds) = PA_Coord\correct_for_precession($raHour, $raMinutes, $raSeconds, $decDeg, $decMinutes, $decSeconds, $epoch1Day, $epoch1Month, $epoch1Year, $epoch2Day, $epoch2Month, $epoch2Year);

    assert($correctedRAHour == $expectedCorrectedRAHour);
    assert($correctedRAMinutes == $expectedCorrectedRAMinutes);
    assert($correctedRASeconds == $expectedCorrectedRASeconds);
    assert($correctedDecDeg == $expectedCorrectedDecDeg);
    assert($correctedDecMinutes == $expectedCorrectedDecMinutes);
    assert($correctedDecSeconds == $expectedCorrectedDecSeconds);

    echo "[Original] RA {$raHour}:{$raMinutes}:{$raSeconds} Declination {$decDeg} d {$decMinutes} m {$decSeconds} s, Epoch 1 {$epoch1Month}/{$epoch1Day}/{$epoch1Year} Epoch 2 {$epoch2Month}/{$epoch2Day}/{$epoch2Year} = [Corrected] RA {$correctedRAHour}:{$correctedRAMinutes}:{$correctedRASeconds} Declination {$correctedDecDeg} d {$correctedDecMinutes} m {$correctedDecSeconds} s\n";
}

function nutation_in_ecliptic_longitude_and_obliquity($greenwichDay, $greenwichMonth, $greenwichYear, $expectedNutInLongDeg, $expectedNutInOblDeg)
{
    list($nutInLongDeg, $nutInOblDeg) = PA_Coord\nutation_in_ecliptic_longitude_and_obliquity($greenwichDay, $greenwichMonth, $greenwichYear, $expectedNutInLongDeg, $expectedNutInOblDeg);

    assert(round($nutInLongDeg, 9) == $expectedNutInLongDeg);
    assert(round($nutInOblDeg, 7) == $expectedNutInOblDeg);

    echo "[Greenwich Date] {$greenwichMonth}/{$greenwichDay}/{$greenwichYear} = [Long Deg] {$nutInLongDeg}, [Obl Deg] {$nutInOblDeg}\n";
}

function correct_for_aberration($utHour, $utMinutes, $utSeconds, $gwDay, $gwMonth, $gwYear, $trueEclLongDeg, $trueEclLongMin, $trueEclLongSec, $trueEclLatDeg, $trueEclLatMin, $trueEclLatSec, $expectedApparentEclLongDeg, $expectedApparentEclLongMin, $expectedApparentEclLongSec, $expectedApparentEclLatDeg, $expectedApparentEclLatMin, $expectedApparentEclLatSec)
{
    list($apparentEclLongDeg, $apparentEclLongMin, $apparentEclLongSec, $apparentEclLatDeg, $apparentEclLatMin, $apparentEclLatSec) = PA_Coord\correct_for_aberration($utHour, $utMinutes, $utSeconds, $gwDay, $gwMonth, $gwYear, $trueEclLongDeg, $trueEclLongMin, $trueEclLongSec, $trueEclLatDeg, $trueEclLatMin, $trueEclLatSec);

    assert($apparentEclLongDeg == $expectedApparentEclLongDeg);
    assert($apparentEclLongMin == $expectedApparentEclLongMin);
    assert($apparentEclLongSec == $expectedApparentEclLongSec);
    assert($apparentEclLatDeg == $expectedApparentEclLatDeg);
    assert($apparentEclLatMin == $expectedApparentEclLatMin);
    assert($apparentEclLatSec == $expectedApparentEclLatSec);

    echo "[UT] {$utHour}:{$utMinutes}:{$utSeconds} [GW] {$gwMonth}/{$gwDay}/{$gwYear} [True Ecl Long] {$trueEclLongDeg} d {$trueEclLongMin} m {$trueEclLongSec} s [True Ecl Lat] {$trueEclLatDeg} d {$trueEclLatMin} m {$trueEclLatSec} s = [Apparent] [Ecliptic Longitude] {$apparentEclLongDeg} d {$apparentEclLongMin} m {$apparentEclLongSec} s [Ecliptic Latitude] {$apparentEclLatDeg} d {$apparentEclLatMin} m {$apparentEclLatSec} s\n";
}

function atmospheric_refraction($trueRAHour, $trueRAMin, $trueRASec, $trueDecDeg, $trueDecMin, $trueDecSec, PA_Types\CoordinateType $coordinateType, $geogLongDeg, $geogLatDeg, $daylightSavingHours, $timezoneHours, $lcdDay, $lcdMonth, $lcdYear, $lctHour, $lctMin, $lctSec, $atmosphericPressureMbar, $atmosphericTemperatureCelsius, $expectedCorrectedRAHour, $expectedCorrectedRAMin, $expectedCorrectedRASec, $expectedCorrectedDecDeg, $expectedCorrectedDecMin, $expectedCorrectedDecSec)
{
    list($correctedRAHour, $correctedRAMin, $correctedRASec, $correctedDecDeg, $correctedDecMin, $correctedDecSec) = PA_Coord\atmospheric_refraction($trueRAHour, $trueRAMin, $trueRASec, $trueDecDeg, $trueDecMin, $trueDecSec, $coordinateType, $geogLongDeg, $geogLatDeg, $daylightSavingHours, $timezoneHours, $lcdDay, $lcdMonth, $lcdYear, $lctHour, $lctMin, $lctSec, $atmosphericPressureMbar, $atmosphericTemperatureCelsius);

    assert($correctedRAHour == $expectedCorrectedRAHour);
    assert($correctedRAMin == $expectedCorrectedRAMin);
    assert($correctedRASec == $expectedCorrectedRASec);
    assert($correctedDecDeg == $expectedCorrectedDecDeg);
    assert($correctedDecMin == $expectedCorrectedDecMin);
    assert($correctedDecSec == $expectedCorrectedDecSec);

    echo "[True RA] {$trueRAHour}:{$trueRAMin}:{$trueRASec} [True Declination] {$trueDecDeg} d {$trueDecMin} m {$trueDecSec} = [Corrected RA] {$correctedRAHour}:{$correctedRAMin}:{$correctedRASec} [Corrected Declination] {$correctedDecDeg} d {$correctedDecMin} m {$correctedDecSec} s\n";
}

function corrections_for_geocentric_parallax($raHour, $raMin, $raSec, $decDeg, $decMin, $decSec, PA_Types\CoordinateType $coordinateType, $equatorialHorParallaxDeg, $geogLongDeg, $geogLatDeg, $heightM, $daylightSaving, $timezoneHours, $lcdDay, $lcdMonth, $lcdYear, $lctHour, $lctMin, $lctSec, $expectedCorrectedRAHour, $expectedCorrectedRAMin, $expectedCorrectedRASec, $expectedCorrectedDecDeg, $expectedCorrectedDecMin, $expectedCorrectedDecSec)
{
    list($correctedRAHour, $correctedRAMin, $correctedRASec, $correctedDecDeg, $correctedDecMin, $correctedDecSec) = PA_Coord\corrections_for_geocentric_parallax($raHour, $raMin, $raSec, $decDeg, $decMin, $decSec, $coordinateType, $equatorialHorParallaxDeg, $geogLongDeg, $geogLatDeg, $heightM, $daylightSaving, $timezoneHours, $lcdDay, $lcdMonth, $lcdYear, $lctHour, $lctMin, $lctSec);

    assert($correctedRAHour == $expectedCorrectedRAHour);
    assert($correctedRAMin == $expectedCorrectedRAMin);
    assert($correctedRASec == $expectedCorrectedRASec);
    assert($correctedDecDeg == $expectedCorrectedDecDeg);
    assert($correctedDecMin == $expectedCorrectedDecMin);
    assert($correctedDecSec == $expectedCorrectedDecSec);

    echo "[Right Ascension] {$raHour}:{$raMin}:{$raSec} [Declination] {$decDeg} d {$decMin} m {$decSec} s = [Corrected RA] {$correctedRAHour}:{$correctedRAMin}:{$correctedRASec} [Corrected Declination] {$correctedDecDeg} d {$correctedDecMin} m {$correctedDecSec} s\n";
}

function heliographic_coordinates($helioPositionAngleDeg, $helioDisplacementArcmin, $gwdateDay, $gwdateMonth, $gwdateYear, $expectedHelioLongDeg, $expectedHelioLatDeg)
{
    list($helioLongDeg, $helioLatDeg) = PA_Coord\heliographic_coordinates($helioPositionAngleDeg, $helioDisplacementArcmin, $gwdateDay, $gwdateMonth, $gwdateYear);

    assert($helioLongDeg == $expectedHelioLongDeg);
    assert($helioLatDeg == $expectedHelioLatDeg);

    echo "[Heliographic Position Angle] {$helioPositionAngleDeg} d [Heliographic Displacement] {$helioDisplacementArcmin} arcmin [Greenwich Date] {$gwdateMonth}/{$gwdateDay}/{$gwdateYear} = [Heliographic Longitude/Latitude] {$helioLongDeg} / {$helioLatDeg} degrees\n";
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
