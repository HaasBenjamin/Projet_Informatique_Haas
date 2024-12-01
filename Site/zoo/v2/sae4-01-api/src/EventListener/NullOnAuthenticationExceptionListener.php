<?php
declare(strict_types=1);

namespace App\EventListener;

use ApiPlatform\OpenApi\Model\Header;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class NullOnAuthenticationExceptionListener
{
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $request = $this->requestStack->getCurrentRequest();
        $route = $request->getPathInfo();
        if ($route === '/api/me') {
            $response = new Response(null, Response::HTTP_FOUND);
            $response->headers->set('Access-Control-Allow-Origin', 'http://localhost:5173');
            $response->headers->set('Access-Control-Allow-Methods', 'GET, OPTIONS');
            $event->setResponse($response);
        }
        return;
    }
}
