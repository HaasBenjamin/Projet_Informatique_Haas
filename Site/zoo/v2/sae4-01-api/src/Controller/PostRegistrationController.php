<?php

namespace App\Controller;

use App\Entity\Registration;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PostRegistrationController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager,
        private readonly UserRepository $userRepository,
        private readonly EventRepository $eventRepository)
    {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(Request $request): JsonResponse
    {
        $registration = new Registration();
        $registration->setNbReservedPlaces((int) $request->get('nbReservedPlaces'));

        $user = $this->userRepository->find((int) $request->get('user'));
        $registration->setUser($user);

        $event = $this->eventRepository->find((int) $request->get('event'));
        $registration->setEvent($event);

        $dateString = $request->get('date');
        $timestamp = strtotime($dateString);
        $date = new \DateTime();
        $date->setTimestamp($timestamp);

        $left = $event->getNbRegisterLeft($date);

        if ($event->getRegistrations()->count() + $request->get('nbReservedPlaces') > $event->getQuota()) {
            $registration->setEvent($event);

            return new JsonResponse("vous pouvez prendre encore  {$left} place(s)", 200);
        }

        $registration->setDate($date);

        $this->entityManager->persist($registration);
        $this->entityManager->flush();

        return new JsonResponse($registration->getId(), Response::HTTP_CREATED);
    }
}
