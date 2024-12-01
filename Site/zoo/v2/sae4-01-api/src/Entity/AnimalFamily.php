<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\AnimalFamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AnimalFamilyRepository::class)]
#[ApiResource(
    operations: [
        new Get(),
        new GetCollection(),
        new Post(security: "is_granted('ROLE_ADMIN')"),
        new Patch(security: "is_granted('ROLE_ADMIN')"),
        new Delete(security: "is_granted('ROLE_ADMIN')"),
        new GetCollection(
            uriTemplate: '/animal_categories/{id}/animal_families',
            uriVariables: [
                'id' => new Link(fromProperty: 'animalFamilies', fromClass: AnimalCategory::class),
            ],
            normalizationContext: ['groups' => ['Family_Read', 'Family_Read_Species']]
        ),
    ],
    normalizationContext: ['groups' => ['Family_Read', 'Family_Read_Category', 'Family_Read_Species']]
)]
class AnimalFamily
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['Family_Read'])]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    #[Groups(['Family_Read'])]
    private ?string $name = null;

    #[ORM\Column(length: 512)]
    #[Groups(['Family_Read'])]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'family', targetEntity: Species::class, orphanRemoval: true)]
    #[Groups(['Family_Read_Species', 'family-Species'])]
    private Collection $species;

    #[ORM\ManyToOne(inversedBy: 'animalFamilies')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['Family_Read_Category'])]
    private ?AnimalCategory $category = null;

    #[ORM\ManyToOne(inversedBy: 'animalFamilies')]
    private ?Image $image = null;

    public function __construct()
    {
        $this->species = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Species>
     */
    public function getSpecies(): Collection
    {
        return $this->species;
    }

    public function addSpecies(Species $species): static
    {
        if (!$this->species->contains($species)) {
            $this->species->add($species);
            $species->setFamily($this);
        }

        return $this;
    }

    public function removeSpecies(Species $species): static
    {
        if ($this->species->removeElement($species)) {
            // set the owning side to null (unless already changed)
            if ($species->getFamily() === $this) {
                $species->setFamily(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?AnimalCategory
    {
        return $this->category;
    }

    public function setCategory(?AnimalCategory $category): static
    {
        $this->category = $category;

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
