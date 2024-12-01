<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Controller\GetImageSpeciesController;
use App\Repository\SpeciesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: SpeciesRepository::class)]
#[ApiResource]
#[Get]
#[GetCollection]
#[Post(
    security: "is_granted('ROLE_ADMIN')"
)]
#[Patch(
    security: "is_granted('ROLE_ADMIN')"
)]
#[Delete(
    security: "is_granted('ROLE_ADMIN')"
)]
#[Get(
    uriTemplate: '/species/{id}/image',
    formats: [
        'png' => 'image/png',
    ],
    controller: GetImageSpeciesController::class,
    openapiContext: [
        'content' => [
            'image/png' => [
                'schema' => [
                    'type' => 'string',
                    'format' => 'binary',
                ],
            ],
        ]],
)]
#[GetCollection(
    uriTemplate: '/animal_families/{id}/species',
    uriVariables: [
        'id' => new Link(fromProperty: 'species', fromClass: AnimalFamily::class),
    ],
    normalizationContext: ['groups' => ['family-Species']]
)]
class Species
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['Family_Read_Species', 'Animal_Read_Species', 'Animal_Read_Enclosure', 'family-Species'])]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    #[Groups(['Family_Read_Species', 'Animal_Read_Species', 'Animal_Read_Enclosure', 'family-Species'])]
    private ?string $name = null;

    #[ORM\Column(length: 512)]
    #[Groups(['family-Species'])]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'species')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnimalFamily $family = null;

    #[ORM\OneToMany(mappedBy: 'species', targetEntity: Animal::class, orphanRemoval: true)]
    #[Groups(['animals-species_read', 'family-Species'])]
    private Collection $animals;

    #[ORM\ManyToOne(inversedBy: 'species')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['Diet-species_read'])]
    private ?AnimalDiet $diet = null;

    #[ORM\ManyToOne(inversedBy: 'species')]
    private ?Image $image = null;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
    }

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

    public function getFamily(): ?AnimalFamily
    {
        return $this->family;
    }

    public function setFamily(?AnimalFamily $family): static
    {
        $this->family = $family;

        return $this;
    }

    /**
     * @return Collection<int, Animal>
     */
    public function getAnimals(): Collection
    {
        return $this->animals;
    }

    public function addAnimal(Animal $animal): static
    {
        if (!$this->animals->contains($animal)) {
            $this->animals->add($animal);
            $animal->setSpecies($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getSpecies() === $this) {
                $animal->setSpecies(null);
            }
        }

        return $this;
    }

    public function getDiet(): ?AnimalDiet
    {
        return $this->diet;
    }

    public function setDiet(?AnimalDiet $diet): static
    {
        $this->diet = $diet;

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
