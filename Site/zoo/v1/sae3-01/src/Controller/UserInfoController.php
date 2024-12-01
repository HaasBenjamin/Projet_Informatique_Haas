<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class UserInfoController extends AbstractController
{
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/user/info/registered')]
    public function EventsRegistered(): Response
    {
        $registrations = $this->getUser()->getRegistrations();

        return $this->render('user_info/index.html.twig', [
            'registered' => true,
            'registrations' => $registrations]);
    }
}
