<?php

namespace App\EventSubscriber;

use App\Controller\TokenAuthenticatedController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class TokenSubscriber implements EventSubscriberInterface
{
    public function __construct(private string $apiPass) 
    {
        $this->apiPass = $apiPass;
    }

    public function onKernelController(ControllerEvent $event): void
    {
        $controller = $event->getController();

        if ($controller instanceof TokenAuthenticatedController)
        {
            $request = $event->getRequest();

            $securityToken = $request->headers->get('Authorization');

            if ($securityToken != $this->apiPass)
            {
                throw new AccessDeniedHttpException('Unauthorized!');
            }
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::CONTROLLER => 'onKernelController',];
    }
}