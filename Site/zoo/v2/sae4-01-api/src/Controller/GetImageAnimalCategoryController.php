<?php

namespace App\Controller;

use App\Entity\Animal;
use App\Entity\AnimalCategory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetImageAnimalCategoryController extends AbstractController
{
    public function __invoke(AnimalCategory $category): Response
    {
        $image = $category->getImage()->getImage();
        if (null !== $image) {
            return new Response(
                stream_get_contents($image, -1, 0),
                Response::HTTP_OK,
                ['content-type' => 'image/png']
            );
        }
    }
}
