<?php

namespace App\Controller;

use App\Repository\AnimalCategoryRepository;
use App\Repository\AnimalFamilyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FamiliesController extends AbstractController
{
    #[Route('/families/{idCategory}', name: 'app_families', requirements: ['idCategory' => '\d+'])]
    public function index(int $idCategory, AnimalCategoryRepository $AnimalCategoryRepository, Request $request): Response
    {
        $search = $request->query->get('search', '');

        return $this->render('families/index.html.twig', [
            'families' => $AnimalCategoryRepository->getAllFamilies($idCategory, $search),
            'name' => $AnimalCategoryRepository->find($idCategory)->getName(),
            'category' => true,
            'idCategory' => $idCategory,
            'search' => $search,
        ]);
    }

    #[Route('/families/', name: 'app_families_showAll')]
    public function showAll(AnimalFamilyRepository $AnimalFamilyRepository, Request $request): Response
    {
        $search = $request->query->get('search', '');

        return $this->render('families/index.html.twig', [
            'families' => $AnimalFamilyRepository->getAllFamiliesWithPicture($search),
            'category' => false,
            'search' => $search,
        ]);
    }
}
