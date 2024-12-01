<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\AnimalDietRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AnimalDietRepository::class)]
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
    uriTemplate: '/species/{id}/diet',
    uriVariables: ['id' => new Link(fromProperty: 'diet', fromClass: Species::class)],
    normalizationContext: ['groups' => ['Diet-species_read']]
)]
class AnimalDiet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    #[Groups(['Diet-species_read'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'diet', targetEntity: Species::class, orphanRemoval: true)]
    private Collection $species;

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
            $species->setDiet($this);
        }

        return $this;
    }

    public function removeSpecies(Species $species): static
    {
        if ($this->species->removeElement($species)) {
            // set the owning side to null (unless already changed)
            if ($species->getDiet() === $this) {
                $species->setDiet(null);
            }
        }

        return $this;
    }
}
