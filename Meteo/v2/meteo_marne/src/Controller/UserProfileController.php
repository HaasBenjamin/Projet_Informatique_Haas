<?php

namespace App\Controller;

use App\Entity\Address;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\AddressRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;


class UserProfileController extends AbstractController
{
    /**
     * @Route("/user/profile", name="app_user_profile")
     */
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function index(AddressRepository $addressRepository): Response
    {
        $user = $this->getUser();
        return $this->render('user_profile/index.html.twig', [
            'addresses' => $addressRepository->getAllAddressesOfAUser($user->getId()),
            'user' => $user,
        ]);
    }

    /**
     * @Route("/user/create", name="app_user_create")
     */
    public function create(EntityManagerInterface $entityManager, Request $request,UserPasswordHasherInterface $userPasswordHasher): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $request->get('user')['password'];
            $user->setPassword($userPasswordHasher->hashPassword($user, $password));
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('user_profile/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/user/weather/{id}/{page}", name="app_weather")
     */
    #[IsGranted("IS_AUTHENTICATED_FULLY")]
    public function weather(Address $address,AddressRepository $addressRepository,int $page): Response
    {
        $user = $this->getUser();
        return $this->render('user_profile/weather.html.twig', [
            "city" => $address->getCity(),
            "postalCode" => $address->getPostalCode(),
            "addressId" => $address->getId(),
            'addresses' => $addressRepository->getAllAddressesOfAUser($user->getId()),
            'page' => $page,
        ]);
    }


}
