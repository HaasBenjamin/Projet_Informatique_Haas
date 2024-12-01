<?php

namespace App\Entity;

use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BLOB)]
    private $image;

    #[ORM\OneToMany(mappedBy: 'image', targetEntity: Animal::class)]
    private Collection $animals;

    #[ORM\OneToMany(mappedBy: 'image', targetEntity: Species::class)]
    private Collection $species;

    #[ORM\OneToMany(mappedBy: 'image', targetEntity: AnimalFamily::class)]
    private Collection $AnimalsFamily;

    #[ORM\OneToMany(mappedBy: 'image', targetEntity: AnimalCategory::class)]
    private Collection $AnimalsCategory;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
        $this->species = new ArrayCollection();
        $this->AnimalsFamily = new ArrayCollection();
        $this->AnimalsCategory = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage(): string
    {
        return 'data:image/png;base64,'.base64_encode(stream_get_contents($this->image));
    }

    public function setImage($image): static
    {
        $this->image = $image;

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
            $animal->setImage($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getImage() === $this) {
                $animal->setImage(null);
            }
        }

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
            $species->setImage($this);
        }

        return $this;
    }

    public function removeSpecies(Species $species): static
    {
        if ($this->species->removeElement($species)) {
            // set the owning side to null (unless already changed)
            if ($species->getImage() === $this) {
                $species->setImage(null);
            }
        }

        return $this;
    }

    public function getAnimalsFamily(): Collection
    {
        return $this->AnimalsFamily;
    }

    public function addAnimalFamily(AnimalFamily $AnimalFamily): static
    {
        if (!$this->AnimalsFamily->contains($AnimalFamily)) {
            $this->AnimalsFamily->add($AnimalFamily);
            $AnimalFamily->setImage($this);
        }

        return $this;
    }

    public function removeAnimalFamily(AnimalFamily $AnimalFamily): static
    {
        if ($this->AnimalsFamily->removeElement($AnimalFamily)) {
            // set the owning side to null (unless already changed)
            if ($AnimalFamily->getImage() === $this) {
                $AnimalFamily->setImage(null);
            }
        }

        return $this;
    }

    public function getAnimalsCategory(): Collection
    {
        return $this->AnimalsCategory;
    }

    public function addAnimalCategory(AnimalCategory $AnimalCategory): static
    {
        if (!$this->AnimalsCategory->contains($AnimalCategory)) {
            $this->AnimalsCategory->add($AnimalCategory);
            $AnimalCategory->setImage($this);
        }

        return $this;
    }

    public function removeAnimalCategory(AnimalCategory $AnimalCategory): static
    {
        if ($this->AnimalsCategory->removeElement($AnimalCategory)) {
            // set the owning side to null (unless already changed)
            if ($AnimalCategory->getImage() === $this) {
                $AnimalCategory->setImage(null);
            }
        }

        return $this;
    }
}
