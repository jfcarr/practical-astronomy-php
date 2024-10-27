<?php

namespace PA\Data\Binary;

class BinaryData
{
    /** Name of binary system. */
    public $name;

    /** Period of the orbit. */
    public $period;

    /** Epoch of the perihelion. */
    public $epochPeri;

    /** Longitude of the perihelion. */
    public $longPeri;

    /** Eccentricity of the orbit. */
    public $ecc;

    /** Semi-major axis of the orbit. */
    public $axis;

    /** Orbital inclination. */
    public $incl;

    /** Position angle of the ascending node. */
    public $paNode;

    public function __construct($name, $period, $epochPeri, $longPeri, $ecc, $axis, $incl, $paNode)
    {
        $this->name = $name;
        $this->period = $period;
        $this->epochPeri = $epochPeri;
        $this->longPeri = $longPeri;
        $this->ecc = $ecc;
        $this->axis = $axis;
        $this->incl = $incl;
        $this->paNode = $paNode;
    }
}

class BinaryDataManager
{
    public $binaryRecords;

    public function __construct()
    {

        $this->binaryRecords = [];

        $this->binaryRecords[] = new BinaryData("eta-Cor", 41.623, 1934.008, 219.907, 0.2763, 0.907, 59.025, 23.717);
        $this->binaryRecords[] = new BinaryData("gamma-Vir", 171.37, 1836.433, 252.88, 0.8808, 3.746, 146.05, 31.78);
        $this->binaryRecords[] = new BinaryData("eta-Cas", 480.0, 1889.6, 268.59, 0.497, 11.9939, 34.76, 278.42);
        $this->binaryRecords[] = new BinaryData("zeta-Ori", 1508.6, 2070.6, 47.3, 0.07, 2.728, 72.0, 155.5);
        $this->binaryRecords[] = new BinaryData("alpha-CMa", 50.09, 1894.13, 147.27, 0.5923, 7.5, 136.53, 44.57);
        $this->binaryRecords[] = new BinaryData("delta-Gem", 1200.0, 1437.0, 57.19, 0.11, 6.9753, 63.28, 18.38);
        $this->binaryRecords[] = new BinaryData("alpha-Gem", 420.07, 1965.3, 261.43, 0.33, 6.295, 115.94, 40.47);
        $this->binaryRecords[] = new BinaryData("aplah-CMi", 40.65, 1927.6, 269.8, 0.4, 4.548, 35.7, 284.3);
        $this->binaryRecords[] = new BinaryData("alpha-Cen", 79.92, 1955.56, 231.56, 0.516, 17.583, 79.24, 204.868);
        $this->binaryRecords[] = new BinaryData("alpha Sco", 900.0, 1889.0, 0.0, 0.0, 3.21, 86.3, 273.0);
    }

    public function GetBinaryRecord($name)
    {
        foreach ($this->binaryRecords as $binaryRecord) {
            if ($binaryRecord->name == $name) {
                return $binaryRecord;
            }
        }

        return new BinaryData("NotFound", -99, -99, -99, -99, -99, -99, -99, -99, -99);
    }
}
