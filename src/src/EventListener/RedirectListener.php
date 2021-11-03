<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpFoundation\Cookie;

class RedirectListener
{
    const EXPIRE_AFTER = 1800;

    public function onKernelResponse(ResponseEvent $event)
    {
        $response = $event->getResponse();
        if (!empty($event->getRequest()->get('block-me'))) {
            $response->headers->setCookie(new Cookie('block-me', time() + self::EXPIRE_AFTER, time() + self::EXPIRE_AFTER));
        }
    }
}