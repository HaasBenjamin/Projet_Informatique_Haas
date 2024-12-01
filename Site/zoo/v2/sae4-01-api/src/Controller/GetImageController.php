<?php

namespace App\Controller;

use App\Entity\Image;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class GetImageController extends AbstractController
{
    public function __invoke(Image $image): ?Response
    {
        return new Response(
            stream_get_contents($image->getImage(), -1, 0),
            Response::HTTP_OK,
            ['content-type' => 'image/png']
        );
    }
}
