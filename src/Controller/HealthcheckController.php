<?php declare(strict_types=1);

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/healthcheck")
 */
final class HealthcheckController
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * HealthcheckController constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return Response
     * @Route("/ping")
     */
    public function aliveAction()
    {
        $this->logger->error('This is not an error, just a ping...');

        return new Response('pong', 200);
    }
}