<?php

namespace App\Controller;

use App\Entity\Animal;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetImageAnimalController extends AbstractController
{
    public function __invoke(Animal $entity): ?Response
    {
        $image = $entity->getImage()->getImage();
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
