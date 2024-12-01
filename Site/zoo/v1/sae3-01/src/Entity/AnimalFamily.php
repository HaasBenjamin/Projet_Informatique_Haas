<?php

namespace App\Entity;

use App\Repository\AnimalFamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalFamilyRepository::class)]
class AnimalFamily
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $name = null;

    #[ORM\Column(length: 512)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'family', targetEntity: Species::class, orphanRemoval: true)]
    private Collection $species;

    #[ORM\ManyToOne(inversedBy: 'familleAnimals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnimalCategory $category = null;

    #[ORM\ManyToOne(inversedBy: 'AnimalsFamily')]
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
