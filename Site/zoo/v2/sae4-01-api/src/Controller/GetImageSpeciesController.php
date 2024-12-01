<?php

namespace App\Controller;

use App\Entity\Species;
use PHPUnit\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetImageSpeciesController extends AbstractController
{
    public function __invoke(Species $species): ?Response
    {
        try {
            $image = $species->getImage()->getImage();
        } catch (Exception $exception) {
            return null;
        }
        if (null !== $image) {
            return new Response(
                stream_get_contents($image, -1, 0),
                Response::HTTP_OK,
                ['content-type' => 'image/png']
            );
        }
    }
}
