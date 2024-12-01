<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\AnimalCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AnimalCategoryRepository::class)]
#[ApiResource]
#[Delete(security: "is_granted('ROLE_ADMIN')")]
#[Get]
#[GetCollection]
#[Patch(security: "is_granted('ROLE_ADMIN')")]
#[Post(security: "is_granted('ROLE_ADMIN')")]
class AnimalCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['Family_Read_Category'])]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    #[Groups(['Family_Read_Category'])]
    private ?string $name = null;

    #[ORM\Column(length: 512)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'animalCategories')]
    private ?Image $image = null;

    #[ORM\OneToMany(mappedBy: 'category', targetEntity: AnimalFamily::class, orphanRemoval: true)]
    private Collection $animalFamilies;

    public function __construct()
    {
        $this->animalFamilies = new ArrayCollection();
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

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, AnimalFamily>
     */
    public function getAnimalFamilies(): Collection
    {
        return $this->animalFamilies;
    }

    public function addAnimalFamily(AnimalFamily $animalFamily): static
    {
        if (!$this->animalFamilies->contains($animalFamily)) {
            $this->animalFamilies->add($animalFamily);
            $animalFamily->setAnimalCategory($this);
        }

        return $this;
    }

    public function removeAnimalFamily(AnimalFamily $animalFamily): static
    {
        if ($this->animalFamilies->removeElement($animalFamily)) {
            // set the owning side to null (unless already changed)
            if ($animalFamily->getAnimalCategory() === $this) {
                $animalFamily->setAnimalCategory(null);
            }
        }

        return $this;
    }
}
