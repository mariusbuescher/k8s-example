<?php declare(strict_types=1);

namespace App\Entity;

use JMS\Serializer\Annotation as Serializer;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class School
{
    /**
     * @var UuidInterface
     *
     * @Serializer\Type("uuid")
     */
    private $id;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     */
    private $name;

    /**
     * @var Location
     *
     * @Serializer\Type("App\Entity\Location")
     */
    private $location;

    /**
     * @var bool
     *
     * @Serializer\Type("boolean")
     */
    private $hasWifi;

    /**
     * @var Connection
     *
     * @Serializer\Type("App\Entity\Connection")
     */
    private $managementConnection;

    /**
     * @var Connection
     *
     * @Serializer\Type("App\Entity\Connection")
     */
    private $educationConnection;

    /**
     * School constructor.
     * @param UuidInterface|null $id
     * @param string $name
     * @param Location $location
     * @param bool $hasWifi
     * @param Connection $managementConnection
     * @param Connection $educationConnection
     */
    public function __construct(
        UuidInterface $id,
        string $name,
        Location $location,
        bool $hasWifi,
        Connection $managementConnection,
        Connection $educationConnection
    ) {
        $this->id = $id ?? Uuid::uuid4();
        $this->name = $name;
        $this->location = $location;
        $this->hasWifi = $hasWifi;
        $this->managementConnection = $managementConnection;
        $this->educationConnection = $educationConnection;
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Location
     */
    public function getLocation(): Location
    {
        return $this->location;
    }

    /**
     * @return bool
     */
    public function isHasWifi(): bool
    {
        return $this->hasWifi;
    }

    /**
     * @return Connection
     */
    public function getManagementConnection(): Connection
    {
        return $this->managementConnection;
    }

    /**
     * @return Connection
     */
    public function getEducationConnection(): Connection
    {
        return $this->educationConnection;
    }
}