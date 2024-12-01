<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AddressController extends AbstractController
{
    /**
     * @Route("/address/create", name="app_address_create")
     */
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $address = new Address();
        $form = $this->createForm(AddressType::class, $address);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $address->setUser($this->getUser());
            $entityManager->persist($address);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_profile');
        }

        return $this->render('address/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/address/{id}/delete", name="app_address_delete")
     */
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function delete(Address $address,EntityManagerInterface $entityManager, Request $request): Response
    {
        $form = $this->createFormBuilder()
            ->add('delete', SubmitType::class)
            ->add('cancel', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($form->get('delete')->isClicked()) {
                $entityManager->remove($address);
                $entityManager->flush();
            }
            return $this->redirectToRoute('app_user_profile');
        }

        return $this->render('address/delete.html.twig', [
            'form' => $form->createView(),
            'address' => $address,
        ]);

    }

}
