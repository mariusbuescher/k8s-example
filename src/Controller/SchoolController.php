<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\School;
use App\Geo\Rect;
use App\Pagination\PageRequest;
use App\Repository\SchoolRepository;
use App\School\SchoolCreated;
use JMS\Serializer\SerializerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/schools")
 */
final class SchoolController
{
    /**
     * @var SchoolRepository
     */
    private $schoolRepository;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(SchoolRepository $schoolRepository, SerializerInterface $serializer)
    {
        $this->schoolRepository = $schoolRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Route("/", methods={"GET"})
     */
    public function listAction(PageRequest $pageRequest): Response
    {
        $schools = $this->schoolRepository->findAll($pageRequest);

        return new Response($this->serializer->serialize($schools, 'json'), Response::HTTP_OK);
    }

    /**
     * @Route("/area", methods={"GET"})
     */
    public function getInArea(Rect $area): Response
    {
        return new Response(
            $this->serializer->serialize($this->schoolRepository->findInArea($area), 'json'),
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/{schoolId}", methods={"GET"})
     */
    public function showAction(UuidInterface $schoolId): Response
    {
        return new Response(
            $this->serializer->serialize($this->schoolRepository->get($schoolId), 'json'),
            Response::HTTP_OK
        );
    }

    /**
     * @Route("/{schoolId}", methods={"DELETE"})
     */
    public function deleteAction(UuidInterface $schoolId): Response
    {
        $this->schoolRepository->delete($schoolId);

        return new Response('', Response::HTTP_OK);
    }

    /**
     * @Route("/batch", methods={"POST"})
     */
    public function createBatchAction(Request $request): Response
    {
        /** @var School[] $schools */
        $schools = $this->serializer->deserialize($request->getContent(), 'array<' . School::class . '>', 'json');

        foreach ($schools as $school) {
            $this->schoolRepository->save(new School(
                Uuid::uuid4(),
                $school->getName(),
                $school->getLocation(),
                $school->isHasWifi(),
                $school->getManagementConnection(),
                $school->getEducationConnection()
            ));
        }

        return new JsonResponse([
            'count' => count($schools),
        ], Response::HTTP_CREATED);
    }

    /**
     * @Route("/", methods={"POST"})
     */
    public function createAction(Request $request): Response
    {
        /** @var School $school */
        $school = $this->serializer->deserialize($request->getContent(), School::class, 'json');

        $response = $this->schoolRepository->save(new School(
            Uuid::uuid4(),
            $school->getName(),
            $school->getLocation(),
            $school->isHasWifi(),
            $school->getManagementConnection(),
            $school->getEducationConnection()
        ));

        if ($response instanceof SchoolCreated) {
            return new Response('', Response::HTTP_CREATED);
        }

        return new Response('', Response::HTTP_OK);
    }
}