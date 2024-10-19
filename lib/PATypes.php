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
