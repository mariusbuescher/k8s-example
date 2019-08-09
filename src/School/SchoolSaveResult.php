<?php declare(strict_types=1);

namespace App\School;

use Ramsey\Uuid\UuidInterface;

abstract class SchoolSaveResult
{
    /**
     * @var UuidInterface
     */
    private $schoolId;

    /**
     * SchoolSaveResult constructor.
     * @param UuidInterface $schoolId
     */
    public function __construct(UuidInterface $schoolId)
    {
        $this->schoolId = $schoolId;
    }

    /**
     * @return UuidInterface
     */
    public function getSchoolId(): UuidInterface
    {
        return $this->schoolId;
    }
}