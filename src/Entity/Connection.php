<?php declare(strict_types=1);

namespace App\Entity;

use JMS\Serializer\Annotation as Serializer;

class Connection
{
    /**
     * @var int
     *
     * @Serializer\Type("int")
     */
    private $bandwidth;

    /**
     * @var string
     *
     * @Serializer\Type("string")
     */
    private $connectionType;

    /**
     * @var bool
     *
     * @Serializer\Type("bool")
     */
    private $isSymmetric;

    /**
     * Connection constructor.
     * @param int $bandwidth
     * @param string $connectionType
     * @param bool $isSymmetric
     */
    public function __construct(int $bandwidth, string $connectionType, bool $isSymmetric)
    {
        $this->bandwidth = $bandwidth;
        $this->connectionType = $connectionType;
        $this->isSymmetric = $isSymmetric;
    }

    /**
     * @return int
     */
    public function getBandwidth(): int
    {
        return $this->bandwidth;
    }

    /**
     * @return string
     */
    public function getConnectionType(): string
    {
        return $this->connectionType;
    }

    /**
     * @return bool
     */
    public function isSymmetric(): bool
    {
        return $this->isSymmetric;
    }
}