<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\School;
use App\Geo\Rect;
use App\Pagination\PageRequest;
use App\School\SchoolSaveResult;
use App\School\SchoolsResult;
use App\Exception\SchoolNotFoundException;
use Ramsey\Uuid\UuidInterface;

interface SchoolRepository
{
    public function save(School $school): SchoolSaveResult;

    public function findAll(PageRequest $pageRequest = null): SchoolsResult;

    public function findInArea(Rect $area): \Iterator;

    /**
     * @param UuidInterface $uuid
     * @return School
     * @throws SchoolNotFoundException
     */
    public function get(UuidInterface $uuid): School;

    /**
     * @param UuidInterface $schoolId
     * @return void
     * @throws SchoolNotFoundException
     */
    public function delete(UuidInterface $schoolId);
}