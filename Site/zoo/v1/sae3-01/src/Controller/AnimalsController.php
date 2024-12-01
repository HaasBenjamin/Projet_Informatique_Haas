<?php

namespace App\Controller;

use App\Repository\AnimalRepository;
use App\Repository\SpeciesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AnimalsController extends AbstractController
{
    #[Route('/animals/{idSpecies}', name: 'app_animals', requirements: ['idSpecies' => '\d+'])]
    public function index(int $idSpecies, SpeciesRepository $speciesRepository, Request $request): Response
    {
        $search = $request->query->get('search', '');
        $species = $speciesRepository->getAllAnimals($idSpecies, $search);

        return $this->render('animals/index.html.twig', [
            'animals' => $species,
            'name' => $speciesRepository->find($idSpecies)->getName(),
            'species' => true,
            'search' => $search,
            'idSpecies' => $idSpecies,
        ]);
    }

    #[Route('/animals/', name: 'app_animals_showall')]
    public function showAll(AnimalRepository $animalRepository, Request $request): Response
    {
        $search = $request->query->get('search', '');

        return $this->render('animals/index.html.twig', [
            'animals' => $animalRepository->getAllAnimalsWithPicture($search),
            'species' => false,
            'search' => $search,
        ]);
    }
}
