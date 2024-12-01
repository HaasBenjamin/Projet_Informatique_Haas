<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\Image;
use App\Form\AnimalType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalController extends AbstractController
{
    #[Route('/animal', name: 'app_animal')]
    public function index(): Response
    {
        return $this->render('animal/index.html.twig', [
            'controller_name' => 'AnimalController',
        ]);
    }

    #[Route('/animal/{id}', name: 'app_animal_show', requirements: ['id' => '\d+'])]
    public function show(Animal $animal = null): Response
    {
        if (!$animal) {
            return $this->redirectToRoute('app_animals_showall');
        }

        return $this->render('animal/show.html.twig', [
            'animal' => $animal,
            'nbRegister' => $animal->getEnclosure()->getNbRegister(new \DateTimeImmutable(date('Y-m-d H:i:s'))),
        ]);
    }

    #[Route('/animal/{id}/update', requirements: ['id' => '\d+'])]
    public function update(EntityManagerInterface $entityManager, Animal $animal, Request $request): RedirectResponse|Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (null === $animal->getImage()) {
                if (null !== $form->get('image')->getData()) {
                    $image = new Image();
                    $animal->setImage($image);
                    $image->setImage(file_get_contents($form->get('image')->getData()));
                    $entityManager->persist($image);
                }
            } else {
                $image = $animal->getImage();
                $entityManager->persist($image);
            }
            $entityManager->flush();

            return $this->redirectToRoute('app_animal_show', ['id' => $animal->getId()], 301);
        }

        /* @var FormView $form */
        return $this->render('animal/update.html.twig', ['animal' => $animal, 'form' => $form]);
    }

    #[Route('/animal/create')]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $animal = new Animal();
        $form = $this->createForm(AnimalType::class, $animal);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if (null !== $form->get('image')->getData()) {
                $image = new Image();
                $image->setImage(file_get_contents($form->get('image')->getData()));
                $entityManager->persist($image);
                $animal->setImage($image);
            }
            $entityManager->persist($animal);
            $entityManager->flush();

            return $this->redirectToRoute('app_animal_show', ['id' => $animal->getId()], 301);
        }

        /* @var FormView $form */
        return $this->render('animal/create.html.twig', ['form' => $form]);
    }

    #[Route('/animal/{id}/delete', name: 'app_animal_delete', requirements: ['id' => '\d+'])]
    public function delete(
        Animal $animal,
        EntityManagerInterface $entityManager,
        Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $form = $this->createFormBuilder()
            ->add('delete', SubmitType::class)
            ->add('cancel', SubmitType::class)
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('delete')->isClicked()) {
                $entityManager->remove($animal);
                if (null !== $image = $animal->getImage()) {
                    $entityManager->remove($image);
                }
                $entityManager->flush();

                return $this->redirectToRoute('app_animals_showall');
            }

            return $this->redirectToRoute('app_animal_show', ['id' => $animal->getId()], 301);
        }

        /* @var FormView $form */
        return $this->render('animal/delete.html.twig', [
            'form' => $form,
            'animal' => $animal,
        ]);
    }
}
