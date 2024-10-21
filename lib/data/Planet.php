<?php

namespace PA\Data\Planets;

class PlanetData
{
    /**
     * Name of planet.
     */
    public $name;

    /**
     * Period of orbit.
     * 
     * Original element name: tp
     */
    public $tp_PeriodOrbit;

    /**
     * Longitude at the epoch.
     * 
     * Original element name: long
     */
    public $long_LongitudeEpoch;

    /**
     * Longitude of the perihelion.
     * 
     * Original element name: peri
     */
    public $peri_LongitudePerihelion;

    /**
     * Eccentricity of the orbit.
     * 
     * Original element name: ecc
     */
    public $ecc_EccentricityOrbit;

    /**
     * Semi-major axis of the orbit.
     * 
     * Original element name: axis
     */
    public $axis_AxisOrbit;

    /**
     * Orbital inclination.
     * 
     * Original element name: incl
     */
    public $incl_OrbitalInclination;

    /**
     * Longitude of the ascending node.
     * 
     * Original element name: node
     */
    public $node_LongitudeAscendingNode;

    /**
     * Angular diameter at 1 AU.
     * 
     * Original element name: theta0
     */
    public $theta0_AngularDiameter;

    /**
     * Visual magnitude at 1 AU.
     * 
     * Original element name: v0
     */
    public  $v0_VisualMagnitude;


    public function __construct($name, $tp_PeriodOrbit, $long_LongitudeEpoch, $peri_LongitudePerihelion, $ecc_EccentricityOrbit, $axis_AxisOrbit, $incl_OrbitalInclination, $node_LongitudeAscendingNode, $theta0_AngularDiameter, $v0_VisualMagnitude)
    {
        $this->name = $name;
        $this->tp_PeriodOrbit = $tp_PeriodOrbit;
        $this->long_LongitudeEpoch = $long_LongitudeEpoch;
        $this->peri_LongitudePerihelion = $peri_LongitudePerihelion;
        $this->ecc_EccentricityOrbit = $ecc_EccentricityOrbit;
        $this->axis_AxisOrbit = $axis_AxisOrbit;
        $this->incl_OrbitalInclination = $incl_OrbitalInclination;
        $this->node_LongitudeAscendingNode = $node_LongitudeAscendingNode;
        $this->theta0_AngularDiameter = $theta0_AngularDiameter;
        $this->v0_VisualMagnitude = $v0_VisualMagnitude;
    }
}

class PlanetDataManager
{
    public $planetRecords;

    public function __construct()
    {
        $this->planetRecords = [];

        $this->planetRecords[] = new PlanetData("Mercury", 0.24085, 75.5671, 77.612, 0.205627, 0.387098, 7.0051, 48.449, 6.74, -0.42);
        $this->planetRecords[] = new PlanetData("Venus", 0.615207, 272.30044, 131.54, 0.006812, 0.723329, 3.3947, 76.769, 16.92, -4.4);
        $this->planetRecords[] = new PlanetData("Earth", 0.999996, 99.556772, 103.2055, 0.016671, 0.999985, -99.0, -99.0, -99.0, -99.0);
        $this->planetRecords[] = new PlanetData("Mars", 1.880765, 109.09646, 336.217, 0.093348, 1.523689, 1.8497, 49.632, 9.36, -1.52);
        $this->planetRecords[] = new PlanetData("Jupiter", 11.857911, 337.917132, 14.6633, 0.048907, 5.20278, 1.3035, 100.595, 196.74, -9.4);
        $this->planetRecords[] = new PlanetData("Saturn", 29.310579, 172.398316, 89.567, 0.053853, 9.51134, 2.4873, 113.752, 165.6, -8.88);
        $this->planetRecords[] = new PlanetData("Uranus", 84.039492, 356.135400, 172.884833, 0.046321, 19.21814, 0.773059, 73.926961, 65.8, -7.19);
        $this->planetRecords[] = new PlanetData("Neptune", 165.845392, 326.895127, 23.07, 0.010483, 30.1985, 1.7673, 131.879, 62.2, -6.87);
    }

    public function GetPlanetRecord($name)
    {
        foreach ($this->planetRecords as $planetRecord) {
            if ($planetRecord->name == $name) {
                return $planetRecord;
            }
        }

        return new PlanetData("NotFound", -99, -99, -99, -99, -99, -99, -99, -99, -99);
    }
}
