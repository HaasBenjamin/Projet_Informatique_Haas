<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(Request $request, ContactRepository $contactRepository): Response
    {
        $search = $request->query->get('search', '');
        $contacts = $contactRepository->search($search);

        /* ajouter dans la vue */
        return $this->render('contact/index.html.twig', ['contacts' => $contacts, 'search' => $search]);
    }

    #[Route('/contact/{id}', requirements: ['id' => '\d+'])]
    public function show(
        #[MapEntity(expr: 'repository.findWithCategory(id)')]
        Contact $contact): Response
    {
        return $this->render('contact/show.html.twig', ['contact' => $contact]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/contact/{id}/update', requirements: ['id' => '\d+'])]
    public function update(EntityManagerInterface $entityManager, Request $request, Contact $contact): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contact = $form->getData();
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_show', ['id' => $contact->getId()]);
        }

        return $this->render('contact/update.html.twig', [
            'form' => $form,
            'contact' => $contact,
        ]);
    }

    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    #[Route('/contact/create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/create.html.twig', [
            'form' => $form,
            'contact' => $contact,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/contact/{id}/delete', requirements: ['id' => '\d+'])]
    public function delete(Contact $contact, EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('delete', SubmitType::class)
            ->add('cancel', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('delete')->isClicked()) {
                $entityManager->remove($contact);
                $entityManager->flush();

                return $this->redirectToRoute('app_contact');
            }

            return $this->redirectToRoute('app_contact_show', ['id' => $contact->getId()]);
        }

        return $this->render('contact/delete.html.twig', [
            'form' => $form,
            'contact' => $contact,
        ]);
    }
}
