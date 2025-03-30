<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetAvatarController extends AbstractController
{
    public function __invoke(User $user): Response
    {
        $response = new Response();
        $response->headers->set('Content-Type', 'image/png');
        $response->setContent(stream_get_contents($user->getAvatar(), -1, 0));
        return $response;
    }
}
