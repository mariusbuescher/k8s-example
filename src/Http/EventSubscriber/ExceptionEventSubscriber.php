<?php declare(strict_types=1);

namespace App\Http\EventSubscriber;

use App\Exception\SchoolNotFoundException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class ExceptionEventSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::EXCEPTION => [
                'onKernelException',
            ],
        ];
    }

    public function onKernelException(ExceptionEvent $event)
    {
        if ($event->getException() instanceof SchoolNotFoundException) {
            $event->setResponse(new Response('', Response::HTTP_NOT_FOUND));
        }
    }
}