<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\AnimalRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(security: "is_granted('ROLE_ADMIN')"),
        new Patch(security: "is_granted('ROLE_ADMIN')"),
        new Delete(security: "is_granted('ROLE_ADMIN')"),
        new GetCollection(
            uriTemplate: '/species/{id}/animals',
            uriVariables: [
                'id' => new Link(fromProperty: 'animals', fromClass: Species::class),
            ],
            normalizationContext: ['groups' => ['Animal_Read', 'Animal_Read_Species']]
        ),
        new GetCollection(
            uriTemplate: '/enclosures/{id}/animals',
            uriVariables: [
                'id' => new Link(fromProperty: 'animals', fromClass: Enclosure::class),
            ],
            normalizationContext: ['groups' => ['Animal_Read', 'Animal_Read_Enclosure']]
        ),
    ],
    normalizationContext: ['groups' => ['Animal_Read', 'Animal_Read_Enclosure', 'Animal_Read_Species']]
)]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial'])]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['Animal_Read'])]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    #[Groups(['Animal_Read'])]
    private ?string $name = null;

    #[ORM\Column(length: 512)]
    #[Groups(['Animal_Read'])]
    private ?string $description = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[Groups(['Animal_Read'])]
    private ?self $parent1 = null;

    #[ORM\ManyToOne(targetEntity: self::class)]
    #[Groups(['Animal_Read'])]
    private ?self $parent2 = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['Animal_Read_Species', 'Animal_Read_Enclosure'])]
    private ?Species $species = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['Animal_Read_Enclosure'])]
    private ?Enclosure $enclosure = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[Groups(['Animal_Read'])]
    private ?Image $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getParent1(): ?self
    {
        return $this->parent1;
    }

    public function setParent1(?self $parent1): static
    {
        $this->parent1 = $parent1;

        return $this;
    }

    public function getParent2(): ?self
    {
        return $this->parent2;
    }

    public function setParent2(?self $parent2): static
    {
        $this->parent2 = $parent2;

        return $this;
    }

    public function getSpecies(): ?Species
    {
        return $this->species;
    }

    public function setSpecies(?Species $species): static
    {
        $this->species = $species;

        return $this;
    }

    public function getEnclosure(): ?Enclosure
    {
        return $this->enclosure;
    }

    public function setEnclosure(?Enclosure $enclosure): static
    {
        $this->enclosure = $enclosure;

        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
    {
        $this->image = $image;

        return $this;
    }
}
