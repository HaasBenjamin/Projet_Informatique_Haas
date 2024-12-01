<?php

namespace App\Controller;

use App\Entity\AnimalFamily;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetImageAnimalFamilyController extends AbstractController
{
    public function __invoke(AnimalFamily $family): ?Response
    {
        $image = $family->getImage()->getImage();
        if (null !== $image) {
            return new Response(
                stream_get_contents($image, -1, 0),
                Response::HTTP_OK,
                ['content-type' => 'image/png']
            );
        }

        return null;
    }
}
