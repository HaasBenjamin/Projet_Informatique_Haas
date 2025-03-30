<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\RatingRepository;
use App\Validator\IsAuthenticatedUser;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: RatingRepository::class)]
#[ApiResource(normalizationContext: ['groups' => ['Rating_read']])]
#[GetCollection]
#[Post(security: 'user')]
#[Get]
#[Put(security: 'user and object.getUser().getId()==user.getId()')]
#[Delete(security: 'user and object.getUser().getId()==user.getId()')]
#[Patch(security: 'user and object.getUser().getId()==user.getId()')]
#[UniqueEntity(fields: ['bookmark', 'user'])]
#[GetCollection(uriTemplate: '/users/{id}/ratings', uriVariables: ['id' => new Link(toProperty: 'user', fromClass: User::class)], normalizationContext: ['groups' => ['User-rating_read', 'Rating_read']])]
class Rating
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('Rating_read')]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ratings')]
    #[ORM\JoinColumn(nullable: false)]
    #[ApiProperty(example: '/api/bookmarks/{id}')]
    #[Groups('Rating_read')]
    private ?Bookmark $bookmark = null;

    #[ORM\ManyToOne(inversedBy: 'ratings')]
    #[ORM\JoinColumn(nullable: false)]
    #[ApiProperty(example: '/api/users/{id}')]
    #[IsAuthenticatedUser]
    #[Groups('Rating_read')]
    private ?User $user = null;

    #[ORM\Column(type: Types::SMALLINT)]
    #[Assert\LessThanOrEqual(10)]
    #[Assert\Positive]
    #[Groups('Rating_read')]
    private ?int $value = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBookmark(): ?Bookmark
    {
        return $this->bookmark;
    }

    public function setBookmark(?Bookmark $bookmark): static
    {
        $this->bookmark = $bookmark;

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

    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): static
    {
        $this->value = $value;

        return $this;
    }
}
