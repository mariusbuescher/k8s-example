<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Connection;
use App\Entity\Location;
use App\Entity\School;
use App\Exception\SchoolNotFoundException;
use App\Geo\Point;
use App\Geo\Rect;
use App\Pagination\PageInformation;
use App\Pagination\PageRequest;
use App\School\SchoolCreated;
use App\School\SchoolSaveResult;
use App\School\SchoolsResult;
use App\School\SchoolUpdated;
use Doctrine\DBAL\Connection as DBALConnection;
use Doctrine\DBAL\Types\Type;
use Ramsey\Uuid\Doctrine\UuidType;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final class DoctrineSchoolRepository implements SchoolRepository
{
    /**
     * @var DBALConnection
     */
    private $connection;

    /**
     * DoctrineSchoolRepository constructor.
     * @param DBALConnection $connection
     */
    public function __construct(DBALConnection $connection)
    {
        $this->connection = $connection;
    }

    public function save(School $school): SchoolSaveResult
    {
        $count = $this->connection->executeQuery('SELECT COUNT(*) AS count FROM schools WHERE id = :id', [
            'id' => $school->getId(),
        ], [
            'id' => UuidType::NAME,
        ])->fetch(\PDO::FETCH_ASSOC);

        if ($count['count'] === 0) {
            $this->connection->insert('schools', [
                'id' => $school->getId(),
                'name' => $school->getName(),
                'has_wifi' => $school->isHasWifi(),
                'address' => $school->getLocation()->getAddress(),
                'zip' => $school->getLocation()->getZip(),
                'district' => $school->getLocation()->getDistrict(),
                'coordinate_lat' => $school->getLocation()->getCoordinates()->getLat(),
                'coordinate_lng' => $school->getLocation()->getCoordinates()->getLong(),
                'management_conn_bandwidth' => $school->getManagementConnection()->getBandwidth(),
                'management_conn_type' => $school->getManagementConnection()->getConnectionType(),
                'management_conn_is_symmetric' => $school->getManagementConnection()->isSymmetric(),
                'education_conn_bandwidth' => $school->getEducationConnection()->getBandwidth(),
                'education_conn_type' => $school->getEducationConnection()->getConnectionType(),
                'education_conn_is_symmetric' => $school->getEducationConnection()->isSymmetric(),
            ], [
                'id' => UuidType::NAME,
                'name' => Type::STRING,
                'has_wifi' => Type::BOOLEAN,
                'address' => Type::STRING,
                'zip' => Type::STRING,
                'district' => Type::STRING,
                'coordinate_lat' => Type::FLOAT,
                'coordinate_lng' => Type::FLOAT,
                'management_conn_bandwidth' => Type::INTEGER,
                'management_conn_type' => Type::STRING,
                'management_conn_is_symmetric' => Type::BOOLEAN,
                'education_conn_bandwidth' => Type::INTEGER,
                'education_conn_type' => Type::STRING,
                'education_conn_is_symmetric' => Type::BOOLEAN,
            ]);
            return new SchoolCreated($school->getId());
        }

        $this->connection->update('schools', [
            'name' => $school->getName(),
            'has_wifi' => $school->isHasWifi(),
            'address' => $school->getLocation()->getAddress(),
            'zip' => $school->getLocation()->getZip(),
            'district' => $school->getLocation()->getDistrict(),
            'coordinate_lat' => $school->getLocation()->getCoordinates()->getLat(),
            'coordinate_lng' => $school->getLocation()->getCoordinates()->getLong(),
            'management_conn_bandwidth' => $school->getManagementConnection()->getBandwidth(),
            'management_conn_type' => $school->getManagementConnection()->getConnectionType(),
            'management_conn_is_symmetric' => $school->getManagementConnection()->isSymmetric(),
            'education_conn_bandwidth' => $school->getEducationConnection()->getBandwidth(),
            'education_conn_type' => $school->getEducationConnection()->getConnectionType(),
            'education_conn_is_symmetric' => $school->getEducationConnection()->isSymmetric(),
        ], [
            'id' => $school->getId(),
        ], [
            'id' => UuidType::NAME,
            'name' => Type::STRING,
            'has_wifi' => Type::BOOLEAN,
            'address' => Type::STRING,
            'zip' => Type::STRING,
            'district' => Type::STRING,
            'coordinate_lat' => Type::FLOAT,
            'coordinate_lng' => Type::FLOAT,
            'management_conn_bandwidth' => Type::INTEGER,
            'management_conn_type' => Type::STRING,
            'management_conn_is_symmetric' => Type::BOOLEAN,
            'education_conn_bandwidth' => Type::INTEGER,
            'education_conn_type' => Type::STRING,
            'education_conn_is_symmetric' => Type::BOOLEAN,
        ]);
        return new SchoolUpdated($school->getId());
    }

    public function findAll(PageRequest $pageRequest = null): SchoolsResult
    {
        $count = $this->connection->createQueryBuilder()
            ->select('COUNT(s) AS count')
            ->from('schools', 's')
            ->execute()
            ->fetch(\PDO::FETCH_ASSOC);

        $rawData = $this->connection->createQueryBuilder()
            ->select(
                's.id',
                's.name',
                's.has_wifi',
                's.address',
                's.zip',
                's.district',
                's.coordinate_lat',
                's.coordinate_lng',
                's.management_conn_bandwidth',
                's.management_conn_type',
                's.management_conn_is_symmetric',
                's.education_conn_bandwidth',
                's.education_conn_type',
                's.education_conn_is_symmetric'
            )
            ->from('schools', 's')
            ->setMaxResults($pageRequest->getPageSize())
            ->setFirstResult(($pageRequest->getPageNum() - 1) * $pageRequest->getPageSize())
            ->execute()
            ->fetchAll(\PDO::FETCH_ASSOC);

        $total = (int) $count['count'];
        $totalPages = (int) ceil($total / $pageRequest->getPageSize());

        return new SchoolsResult(
            $total,
            new PageInformation(
                $pageRequest->getPageNum(),
                $totalPages,
                $pageRequest->getPageSize()
            ),
            new \ArrayIterator(array_map([$this, 'mapRawDataToObject'], $rawData))
        );
    }

    public function findInArea(Rect $area): \Iterator
    {
        $rawData = $this->connection->createQueryBuilder()
            ->select(
                's.id',
                's.name',
                's.has_wifi',
                's.address',
                's.zip',
                's.district',
                's.coordinate_lat',
                's.coordinate_lng',
                's.management_conn_bandwidth',
                's.management_conn_type',
                's.management_conn_is_symmetric',
                's.education_conn_bandwidth',
                's.education_conn_type',
                's.education_conn_is_symmetric'
            )
            ->from('schools', 's')
            ->where('s.coordinate_lat < :upLeftLat')
            ->andWhere('s.coordinate_lat > :bottomRightLat')
            ->andWhere('s.coordinate_lng < :bottomRightLng')
            ->andWhere('s.coordinate_lng > :upLeftLng')
            ->setParameter('upLeftLat', $area->getUpperLeft()->getLat())
            ->setParameter('bottomRightLat', $area->getLowerRight()->getLat())
            ->setParameter('bottomRightLng', $area->getLowerRight()->getLong())
            ->setParameter('upLeftLng', $area->getUpperLeft()->getLong())
            ->execute()
            ->fetchAll(\PDO::FETCH_ASSOC);

        return new \ArrayIterator(array_map([$this, 'mapRawDataToObject'], $rawData));
    }

    public function get(UuidInterface $uuid): School
    {
        $rawData = $this->connection->createQueryBuilder()
            ->select(
                's.id',
                's.name',
                's.has_wifi',
                's.address',
                's.zip',
                's.district',
                's.coordinate_lat',
                's.coordinate_lng',
                's.management_conn_bandwidth',
                's.management_conn_type',
                's.management_conn_is_symmetric',
                's.education_conn_bandwidth',
                's.education_conn_type',
                's.education_conn_is_symmetric'
            )
            ->from('schools', 's')
            ->where('id = :id')
            ->setParameter('id', $uuid, UuidType::NAME)
            ->execute()
            ->fetch(\PDO::FETCH_ASSOC);

        if (!is_array($rawData)) {
            throw new SchoolNotFoundException($uuid);
        }

        return $this->mapRawDataToObject($rawData);
    }

    private function mapRawDataToObject(array $rawData): School
    {
        return new School(
            Uuid::fromString($rawData['id']),
            $rawData['name'],
            new Location(
                $rawData['address'],
                $rawData['zip'],
                $rawData['district'],
                new Point(
                    (float) $rawData['coordinate_lat'],
                    (float) $rawData['coordinate_lng']
                )
            ),
            $rawData['has_wifi'],
            new Connection(
                $rawData['management_conn_bandwidth'],
                $rawData['management_conn_type'],
                $rawData['management_conn_is_symmetric']
            ),
            new Connection(
                $rawData['education_conn_bandwidth'],
                $rawData['education_conn_type'],
                $rawData['education_conn_is_symmetric']
            )
        );
    }

    public function delete(UuidInterface $schoolId)
    {
        $deletedSchools = $this->connection->delete('school', [
            'id' => $schoolId
        ], [
            'id' => UuidType::NAME,
        ]);

        if ($deletedSchools === 0) {
            throw new SchoolNotFoundException($schoolId);
        }
    }
}