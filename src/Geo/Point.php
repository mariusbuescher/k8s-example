<?php declare(strict_types=1);

namespace App\Geo;

use JMS\Serializer\Annotation as Serializer;

final class Point
{
    /**
     * @var float
     *
     * @Serializer\Type("float")
     */
    private $lat;

    /**
     * @var float
     *
     * @Serializer\Type("float")
     */
    private $long;

    /**
     * Coordinates constructor.
     * @param float $lat
     * @param float $long
     */
    public function __construct(float $lat, float $long)
    {
        $this->lat = $lat;
        $this->long = $long;
    }

    /**
     * @return float
     */
    public function getLat(): float
    {
        return $this->lat;
    }

    /**
     * @return float
     */
    public function getLong(): float
    {
        return $this->long;
    }
}