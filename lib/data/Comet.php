<?php

namespace PA\Data\Comet;

class CometDataElliptical
{
    /** Name of comet */
    public $name;

    /** Epoch of the perihelion */
    public $epoch_EpochOfPerihelion;

    /** Longitude of the perihelion */
    public $peri_LongitudeOfPerihelion;

    /** Longitude of the ascending node */
    public $node_LongitudeOfAscendingNode;

    /** Period of the orbit */
    public $period_PeriodOfOrbit;

    /** Semi-major axis of the orbit */
    public $axis_SemiMajorAxisOfOrbit;

    /** Eccentricity of the orbit */
    public $ecc_EccentricityOfOrbit;

    /** Inclination of the orbit */
    public $incl_InclinationOfOrbit;

    public function __construct($name, $epoch_EpochOfPerihelion, $peri_LongitudeOfPerihelion, $node_LongitudeOfAscendingNode, $period_PeriodOfOrbit, $axis_SemiMajorAxisOfOrbit, $ecc_EccentricityOfOrbit, $incl_InclinationOfOrbit)
    {
        $this->name = $name;
        $this->epoch_EpochOfPerihelion = $epoch_EpochOfPerihelion;
        $this->peri_LongitudeOfPerihelion = $peri_LongitudeOfPerihelion;
        $this->node_LongitudeOfAscendingNode = $node_LongitudeOfAscendingNode;
        $this->period_PeriodOfOrbit = $period_PeriodOfOrbit;
        $this->axis_SemiMajorAxisOfOrbit = $axis_SemiMajorAxisOfOrbit;
        $this->ecc_EccentricityOfOrbit = $ecc_EccentricityOfOrbit;
        $this->incl_InclinationOfOrbit = $incl_InclinationOfOrbit;
    }
}

class CometDataParabolic
{
    /** Name of comet */
    public $name;

    /** Epoch perihelion day */
    public $epochPeriDay;

    /** Epoch perihelion month */
    public $epochPeriMonth;

    /** Epoch perihelion year */
    public $epochPeriYear;

    /** Arg perihelion */
    public $argPeri;

    /** Comet's node */
    public $node;

    /** Distance at the perihelion */
    public $periDist;

    /** Inclination */
    public $incl;

    public function __construct($name, $epochPeriDay, $epochPeriMonth, $epochPeriYear, $argPeri, $node, $periDist, $incl)
    {
        $this->name = $name;
        $this->epochPeriDay = $epochPeriDay;
        $this->epochPeriMonth = $epochPeriMonth;
        $this->epochPeriYear = $epochPeriYear;
        $this->argPeri = $argPeri;
        $this->node = $node;
        $this->periDist = $periDist;
        $this->incl = $incl;
    }
}

class CometDataManager
{
    public $cometEllipticalRecords;
    public $cometParabolicRecords;

    public function __construct()
    {
        $this->cometEllipticalRecords = [];
        $this->cometParabolicRecords = [];

        $this->cometEllipticalRecords[] = new CometDataElliptical("Encke", 1974.32, 160.1, 334.2, 3.3, 2.21, 0.85, 12.0);
        $this->cometEllipticalRecords[] = new CometDataElliptical("Temple 2", 1972.87, 310.2, 119.3, 5.26, 3.02, 0.55, 12.5);
        $this->cometEllipticalRecords[] = new CometDataElliptical("Haneda-Campos", 1978.77, 12.02, 131.7, 5.37, 3.07, 0.64, 5.81);
        $this->cometEllipticalRecords[] = new CometDataElliptical("Schwassmann-Wachmann 2", 1974.7, 123.3, 126.0, 6.51, 3.49, 0.39, 3.7);
        $this->cometEllipticalRecords[] = new CometDataElliptical("Borrelly", 1974.36, 67.8, 75.1, 6.76, 3.58, 0.63, 30.2);
        $this->cometEllipticalRecords[] = new CometDataElliptical("Whipple", 1970.77, 18.2, 188.4, 7.47, 3.82, 0.35, 10.2);
        $this->cometEllipticalRecords[] = new CometDataElliptical("Oterma", 1958.44, 150.0, 155.1, 7.88, 3.96, 0.14, 4.0);
        $this->cometEllipticalRecords[] = new CometDataElliptical("Schaumasse", 1960.29, 138.1, 86.2, 8.18, 4.05, 0.71, 12.0);
        $this->cometEllipticalRecords[] = new CometDataElliptical("Comas Sola", 1969.83, 102.9, 62.8, 8.55, 4.18, 0.58, 13.4);
        $this->cometEllipticalRecords[] = new CometDataElliptical("Schwassmann-Wachmann 1", 1974.12, 334.1, 319.6, 15.03, 6.09, 0.11, 9.7);
        $this->cometEllipticalRecords[] = new CometDataElliptical("Neujmin 1", 1966.94, 334.0, 347.2, 17.93, 6.86, 0.78, 15.0);
        $this->cometEllipticalRecords[] = new CometDataElliptical("Crommelin", 1956.82, 86.4, 250.4, 27.89, 9.17, 0.92, 28.9);
        $this->cometEllipticalRecords[] = new CometDataElliptical("Olbers", 1956.46, 150.0, 85.4, 69.47, 16.84, 0.93, 44.6);
        $this->cometEllipticalRecords[] = new CometDataElliptical("Pons-Brooks", 1954.39, 94.2, 255.2, 70.98, 17.2, 0.96, 74.2);
        $this->cometEllipticalRecords[] = new CometDataElliptical("Halley", 1986.112, 170.011, 58.154, 76.0081, 17.9435, 0.9673, 162.2384);

        $this->cometParabolicRecords[] = new CometDataParabolic("Kohler", 10.5659, 11, 1977, 163.4799, 181.8175, 0.990662, 48.7196);
    }

    public function GetEllipticalRecord($name)
    {
        foreach ($this->cometEllipticalRecords as $ellipticalRecord) {
            if ($ellipticalRecord->name == $name) {
                return $ellipticalRecord;
            }
        }

        return new CometDataElliptical("NotFound", -99, -99, -99, -99, -99, -99, -99, -99, -99);
    }

    public function GetParabolicRecord($name)
    {
        foreach ($this->cometParabolicRecords as $parabolicRecord) {
            if ($parabolicRecord->name == $name) {
                return $parabolicRecord;
            }
        }

        return new CometDataParabolic("NotFound", -99, -99, -99, -99, -99, -99, -99, -99, -99);
    }
}
