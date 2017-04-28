<?php

namespace MainBundle\EventListner;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class HttpNotFoundListener
{

    public function onKernelException(GetResponseForExceptionEvent $event)
    {

        if(!$event->getException() instanceof NotFoundHttpException){
            return;
        }

        $response = new Response();

        $response->setContent('Object is not found');

        $event->setResponse($response);
    }

}
