<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use App\Controller\PatchRegistrationController;
use App\Controller\PostRegistrationController;
use App\Repository\RegistrationRepository;
use App\Validator\IsAuthenticatedUserOrAdmin;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: RegistrationRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['Registration_read']])]
#[Get(normalizationContext: ['groups' => ['Registration_read', 'User-registrations_read', 'Event-registrations-read']],
    security: "(user and user.getId()===object.getUser().getId()) or is_granted('ROLE_ADMIN')",
)]
#[GetCollection(normalizationContext: ['groups' => ['Registration_read', 'User-registrations_read', 'Event-registrations-read']],
)]
#[Delete(security: 'user and user.getId()===object.getUser().getId()')]
#[Patch(
    controller: PatchRegistrationController::class,
    normalizationContext: ['groups' => ['Registration_read']],
    denormalizationContext: ['groups' => ['Registration_write']],
    security: 'user and user.getId()===object.getUser().getId()',
    deserialize: false
)]
#[Post(inputFormats: ['multipart' => ['multipart/form-data']],
    controller: PostRegistrationController::class,
    openapi: new Model\Operation(
        requestBody: new Model\RequestBody(
            content: new \ArrayObject([
                'multipart/form-data' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'user' => ['type' => 'string'],
                            'events' => ['type' => 'string'],
                            'date' => ['type' => 'datetime'],
                            'nbReservedPlaces' => ['type' => 'number'],
                        ],
                    ],
                ],
            ])
        )
    ),
    deserialize: false,
)]
#[UniqueEntity(fields: ['user', 'date'])]
class Registration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['Registration_read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['Registration_read', 'Registration_write'])]
    private ?\DateTimeInterface $date = null;

    #[ORM\Column]
    #[Groups(['Registration_read', 'Registration_write'])]
    private ?int $nbReservedPlaces = null;

    #[ORM\ManyToOne(inversedBy: 'registrations')]
    #[Groups(['Registration_read'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    #[ORM\ManyToOne(inversedBy: 'registrations')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['Registration_read'])]
    #[IsAuthenticatedUserOrAdmin]
    private ?User $user = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getNbReservedPlaces(): ?int
    {
        return $this->nbReservedPlaces;
    }

    public function setNbReservedPlaces(int $nbReservedPlaces): static
    {
        $this->nbReservedPlaces = $nbReservedPlaces;

        return $this;
    }

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
