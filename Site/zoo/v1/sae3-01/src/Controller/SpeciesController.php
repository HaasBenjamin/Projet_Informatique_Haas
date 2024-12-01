<?php

namespace App\Controller;

use App\Repository\AnimalFamilyRepository;
use App\Repository\SpeciesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpeciesController extends AbstractController
{
    #[Route('/species/{idFamily}', requirements: ['idFamily' => '\d+'])]
    public function index(int $idFamily, AnimalFamilyRepository $AnimalFamilyRepository, Request $request): Response
    {
        $search = $request->query->get('search', '');
        $family = $AnimalFamilyRepository->getAllSpecies($idFamily, $search);
        $familyName = '';
        if ([] != $family) {
            $familyName = $family[0]->getName();
        }

        return $this->render('species/index.html.twig', [
            'species' => $family,
            'name' => $AnimalFamilyRepository->find($idFamily)?->getName(),
            'family' => true,
            'idFamily' => $idFamily,
            'search' => $search,
        ]);
    }

    #[Route('/species', name: 'app_species_showAll')]
    public function showAll(SpeciesRepository $speciesRepository, Request $request): Response
    {
        $search = $request->query->get('search', '');

        return $this->render('species/index.html.twig', [
            'species' => $speciesRepository->getAllSpeciesWithPicture($search),
            'family' => false,
            'search' => $search,
        ]);
    }
}
