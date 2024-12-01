<?php

namespace App\Entity;

use App\Repository\SpeciesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpeciesRepository::class)]
class Species
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    private ?string $name = null;

    #[ORM\Column(length: 512)]
    private ?string $description = null;

    #[ORM\OneToMany(mappedBy: 'species', targetEntity: Animal::class, orphanRemoval: true)]
    private Collection $animals;

    #[ORM\ManyToOne(inversedBy: 'species')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnimalFamily $family = null;

    #[ORM\ManyToOne(inversedBy: 'species')]
    #[ORM\JoinColumn(nullable: false)]
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

    public function getFamily(): ?AnimalFamily
    {
        return $this->family;
    }

    public function setFamily(?AnimalFamily $family): static
    {
        $this->family = $family;

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
