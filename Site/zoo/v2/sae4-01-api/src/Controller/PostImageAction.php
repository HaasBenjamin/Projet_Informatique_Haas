<?php

namespace App\Controller;

use App\Entity\Image;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

#[AsController]
class PostImageAction extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $uploadedFile = $request->files->get('image')?->getRealPath();

        if (!$uploadedFile) {
            throw new BadRequestHttpException('"image" is required');
        }
        $fileContent = file_get_contents($uploadedFile);
        $newImage = new Image();
        $newImage->setImage($fileContent);
        $this->entityManager->persist($newImage);
        $this->entityManager->flush();

        return new JsonResponse($newImage->getId(), 201);
    }
}
