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
}
