<?php

namespace App\Controller;

use App\Repository\RegistrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Exception\ORMException;
use Doctrine\ORM\OptimisticLockException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PatchRegistrationController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $manager,
        private readonly RegistrationRepository $registrationRepository,
    ) {
    }

    /**
     * @throws OptimisticLockException
     * @throws ORMException
     */
    public function __invoke(Request $request): JsonResponse
    {
        $json = json_decode($request->getContent());
        $registration = $this->registrationRepository->find((int) $request->attributes->get('id'));
        $registration->setNbReservedPlaces((int) $json->nbReservedPlaces);
        $dateString = $json->date;
        $timestamp = strtotime($dateString);
        $date = new \DateTime();
        $event = $registration->getEvent();

        $date->setTimestamp($timestamp);
        $left = $event->getNbRegisterLeft($date);

        if ($event->getRegistrations()->count() + $request->get('nbReservedPlaces') > $event->getQuota()) {
            $registration->setEvent($event);
            throw new BadRequestException("vous pouvez prendre encore  {$left} place(s)");
            // return new JsonResponse("vous pouvez prendre encore  {$left} place(s)", 200);
        }
        $registration->setDate($date);

        $this->manager->persist($registration);
        $this->manager->flush();

        return new JsonResponse($request, Response::HTTP_CREATED);
    }
}
