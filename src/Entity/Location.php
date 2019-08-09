<?php declare(strict_types=1);

namespace App\Entity;

use App\Geo\Point;
use JMS\Serializer\Annotation as Serializer;

class Location
{
    /**
     * @var string
     *
     * @Serializer\Type("string")
     */
    private $address;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     */
    private $zip;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     */
    private $district;

    /**
     * @var Point
     *
     * @Serializer\Type("App\Geo\Point")
     */
    private $coordinates;

    /**
     * Location constructor.
     * @param string $address
     * @param string $zip
     * @param string $district
     * @param Point $coordinates
     */
    public function __construct(
        string $address,
        string $zip,
        string $district,
        Point $coordinates
    ) {
        $this->address = $address;
        $this->zip = $zip;
        $this->district = $district;
        $this->coordinates = $coordinates;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @return string
     */
    public function getZip(): string
    {
        return $this->zip;
    }

    /**
     * @return string
     */
    public function getDistrict(): string
    {
        return $this->district;
    }

    /**
     * @return Point
     */
    public function getCoordinates(): Point
    {
        return $this->coordinates;
    }
}