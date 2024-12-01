<?php

namespace App\Controller;

use App\Entity\Event;
use App\Entity\Registration;
use App\Factory\AssocEventDateFactory;
use App\Factory\EventDateFactory;
use App\Form\EventType;
use App\Form\RegistrationType;
use App\Repository\AnimalRepository;
use App\Repository\AssocEventDateRepository;
use App\Repository\EnclosureRepository;
use App\Repository\EventRepository;
use App\Repository\RegistrationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class EventController extends AbstractController
{
    #[Route('/event/{idEnclosure}', requirements: ['idEnclosure' => '\d+'])]
    public function index(int $idEnclosure, EnclosureRepository $enclosureRepository, Request $request): Response
    {
        $search = $request->query->get('search', '');

        return $this->render('event/index.html.twig', [
            'events' => $enclosureRepository->getAllEvents($idEnclosure, $search),
            'enclosureName' => $enclosureRepository->find($idEnclosure)?->getName(),
            'enclosure' => true,
            'search' => $search,
        ]);
    }

    #[Route('/event/', name: 'app_event_showAll')]
    public function showAll(EventRepository $eventRepository, Request $request): Response
    {
        $search = $request->query->get('search', '');

        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->getAll($search),
            'enclosure' => false,
            'search' => $search,
        ]);
    }

    #[Route('/event/{id}/show', name: 'app_event_show', requirements: ['id' => '\d+'])]
    public function show(
        ?Event $event,
        AssocEventDateRepository $assocEventDateRepository,
        RegistrationRepository $registrationRepository,
        EventRepository $eventRepository
    ): Response {
        if (null === $event) {
            throw $this->createNotFoundException("L'évènement n'existe pas ");
        }
        $user = $this->getUser();
        $registration = null;
        if (null !== $user) {
            $registration = $registrationRepository->getRegistrationForEventAndUser($event->getId(), $user->getId());
            if (empty($registration)) {
                $registration = null;
            } else {
                $registration = $registration[0];
            }
        }

        return $this->render('event/show.html.twig', ['event' => $event,
            'dates' => $assocEventDateRepository->getAllDatesForEvent($event->getId()),
            'isRegister' => null !== $registration,
            'registration' => $registration,
            'enclosure' => false,
            'events' => $eventRepository->getAll(''), ]);
    }

    #[Route('/event/{id}/delete', requirements: ['id' => '\d+'])]
    public function delete(Event $event,
        EntityManagerInterface $entityManager,
        Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createFormBuilder()
            ->add('delete', SubmitType::class)
            ->add('cancel', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($form->get('delete')->isClicked()) {
                $entityManager->remove($event);
                $entityManager->flush();

                return $this->redirectToRoute('app_event_showAll');
            }

            return $this->redirectToRoute('app_event_show', [
                'id' => $event->getId(),
            ]);
        }

        return $this->render('event/delete.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/event/{id}/update', requirements: ['id' => '\d+'])]
    public function update(Event $event, Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (null != $form->get('date')->getData()) {
                dump($event->getEventDates());
                foreach ($event->getEventDates() as $assoc) {
                    $entityManager->remove($assoc);
                    $event->removeAssoc();
                }
                $date = EventDateFactory::createOne(['date' => $form->get('date')->getData()]);
                AssocEventDateFactory::createOne(['eventId' => $event, 'eventDatesId' => $date]);
            }

            $entityManager->flush();

            return $this->redirectToRoute('app_event_showAll');
        }

        return $this->render('event/update.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/event/create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $date = EventDateFactory::createOne(['date' => $form->get('date')->getData()]);
            AssocEventDateFactory::createOne(['eventId' => $event, 'eventDatesId' => $date]);
            $entityManager->persist($event);
            $entityManager->flush();

            return $this->redirectToRoute('app_event_showAll');
        }

        return $this->render('event/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/event/{id}/inscription/create', requirements: ['id' => '\d+'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function InscriptionCreate(
        Event $event,
        Request $request,
        EntityManagerInterface $entityManager,
        EventRepository $eventRepository): Response
    {
        $registration = new Registration();
        $form = $this->createForm(RegistrationType::class, $registration);
        $form->add('hour', ChoiceType::class, [
            'mapped' => false,
            'choices' => $eventRepository->getHours($event->getName()),
            'choice_label' => function ($choice): string {
                return $choice;
            },
            'label' => 'Heure',
        ]);
        $form->add('minute', ChoiceType::class, [
            'mapped' => false,
            'choices' => $eventRepository->getMinutes($event->getName()),
            'choice_label' => function ($choice): string {
                return $choice;
            },
            'label' => 'Minute',
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $registration = $form->getData();
            $registration->setEvent($event);
            $registration->setUser($this->getUser());
            $date = $registration->getDate()->setTime($form->get('hour')->getData(), $form->get('minute')->getData());
            $date = new \DateTimeImmutable($date->format('Y-m-d H:i:s'));
            $registersLeft = $event->getNbRegisterLeft($date);
            if ($registersLeft - $registration->getNbReservedPlaces() < 0) {
                return $this->render('inscription/create.html.twig', [
                    'form' => $form,
                    'event' => $event,
                    'registration_done' => false,
                    'registerLeft' => $registersLeft,
                ]);
            }

            $entityManager->persist($registration);
            $entityManager->flush();

            return $this->redirectToRoute('app_event_validation', [
                'id' => $registration->getEvent()->getId(),
                'idRegistration' => $registration->getId(),
            ]);
        }

        return $this->render('inscription/create.html.twig', [
            'form' => $form,
            'event' => $event,
            'registration_done' => true,
        ]);
    }

    #[Route('/event/inscription/{id}/update', requirements: ['id' => '\d+', 'idRegistration' => '\d+'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function InscriptionUpdate(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        EventRepository $eventRepository,
        RegistrationRepository $registrationRepository): Response
    {
        $registration = $registrationRepository->find($id);
        $event = $registration->getEvent();
        $user = $registration->getUser();
        if ($user !== $this->getUser()) {
            throw $this->createNotFoundException('Vous ne pouvez pas modifier une inscription ne vous appartenant pas');
        }
        $form = $this->createForm(RegistrationType::class, $registration);
        $form->add('hour', ChoiceType::class, [
            'mapped' => false,
            'choices' => $eventRepository->getHours($event->getName()),
            'choice_label' => function ($choice): string {
                return $choice;
            },
            'label' => 'Heure',
        ]);
        $form->add('minute', ChoiceType::class, [
            'mapped' => false,
            'choices' => $eventRepository->getMinutes($event->getName()),
            'choice_label' => function ($choice): string {
                return $choice;
            },
            'label' => 'Minute',
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $date = $registration->getDate()->setTime($form->get('hour')->getData(), $form->get('minute')->getData());
            $date = new \DateTimeImmutable($date->format('Y-m-d H:i:s'));
            $registersLeft = $event->getNbRegisterLeft($date);
            if ($registersLeft - $registration->getNbReservedPlaces() < 0) {
                return $this->render('inscription/update.html.twig', [
                    'form' => $form,
                    'event' => $event,
                    'registration_done' => false,
                    'registerLeft' => $registersLeft,
                ]);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_event_show', [
                'id' => $event->getId(),
            ]);
        }

        return $this->render('inscription/update.html.twig', [
            'event' => $event,
            'registration' => $registration,
            'form' => $form,
            'registration_done' => true,
        ]);
    }

    /**
     * @throws \Exception
     */
    #[Route('/event/inscription/{id}/delete', requirements: ['id' => '\d+'])]
    public function deleteRegistrations(int $id,
        Request $request, EntityManagerInterface $entityManager, RegistrationRepository $registrationRepository): \Symfony\Component\HttpFoundation\RedirectResponse|Response
    {
        $registration = $registrationRepository->find($id);
        $form = $this->createFormBuilder()
            ->add('delete', SubmitType::class)
            ->add('cancel', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        $event = $registration->getEvent();
        if ($form->isSubmitted()) {
            if ($form->getClickedButton() === $form->get('delete')) {
                $origin = new \DateTimeImmutable($registration->getDate()->format('Y-m-d H:i:s'));
                $target = new \DateTimeImmutable(date('Y-m-d H:i:s'));
                $interval = $target->diff($origin);
                if (0 == $interval->invert) {
                    return $this->redirectToRoute('app_event_refund', ['id' => $registration->getId()]);
                }

                return $this->render('inscription/delete.html.twig', [
                    'register' => $registration,
                    'form' => $form,
                    'not_deletable' => true,
                ]);
            }
        }

        return $this->render('inscription/delete.html.twig', [
            'register' => $registration,
            'form' => $form,
            'not_deletable' => false,
        ]);
    }

    #[Route('/event/{id}/{idRegistration}/invoice')]
    public function invoice(Event $event, int $idRegistration, RegistrationRepository $registrationRepository, AnimalRepository $animalRepository): Response
    {
        return $this->render('event/invoice.html.twig', [
            'event' => $event,
            'registration' => $registrationRepository->find($idRegistration),
            'species' => $animalRepository->getAllASpeciesInEnclosure($event->getEnclosure()->getId()),
        ]);
    }

    #[Route('/event/{id}/{idRegistration}/validation')]
    public function validation(Event $event, int $idRegistration, RegistrationRepository $registrationRepository): Response
    {
        $registration = $registrationRepository->find($idRegistration);

        return $this->render('event/validation.html.twig', [
            'event' => $event,
            'registration' => $registration,
        ]);
    }

    #[Route('/event/{id}/refund', requirements: ['id' => '\d+'])]
    public function refund(int $id, RegistrationRepository $registrationRepository, EntityManagerInterface $entityManager): Response
    {
        $registration = $registrationRepository->find($id);
        $event = $registration->getEvent();
        $entityManager->remove($registration);
        $entityManager->flush();

        return $this->render('event/refund.html.twig', [
            'event' => $event,
            'registration' => $registration,
        ]);
    }
}
