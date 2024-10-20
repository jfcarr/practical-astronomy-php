<?php

namespace PA\Types;

enum AngleMeasure: string
{
    case Degrees = "Degrees";
    case Hours = "Hours";
}

enum RiseSetStatus: string
{
    case OK = "OK";
    case NeverRises = "never rises";
    case Circumpolar = "circumpolar";
    case GstToUtConversionWarning = "gst to ut conversion warning";
}

enum CoordinateType: string
{
    case True = "True";
    case Apparent = "Apparent";
}

enum WarningFlag: string
{
    case OK = "OK";
    case Warning = "Warning";
}

enum TwilightType: int
{
    case Civil = 6;
    case Nautical = 12;
    case Astronomical = 18;
}

enum TwilightStatus: string
{
    case OK = "OK";
    case LastsAllNight = "Lasts all night";
    case SunTooFarBelowHorizon = "Sun too far below horizon";
    case GstToUtConversionWarning = "GST to UT conversion warning";
}
