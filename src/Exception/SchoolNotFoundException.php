<?php declare(strict_types=1);

namespace App\Exception;

use Ramsey\Uuid\UuidInterface;
use Throwable;

class SchoolNotFoundException extends \RuntimeException
{
    /**
     * @var UuidInterface
     */
    private $schooldId;

    public function __construct(UuidInterface $schoolId, $code = 0, Throwable $previous = null)
    {
        parent::__construct(sprintf(
            'School with ID %1$s not found.',
            (string) $schoolId
        ), $code, $previous);
    }

    /**
     * @return UuidInterface
     */
    public function getSchooldId(): UuidInterface
    {
        return $this->schooldId;
    }
}