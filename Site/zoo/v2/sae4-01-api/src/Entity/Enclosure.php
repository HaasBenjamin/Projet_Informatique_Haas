<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Link;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\EnclosureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: EnclosureRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['Enclosure-read']]
)]
#[Delete(security: "is_granted('ROLE_ADMIN')")]
#[Get(normalizationContext: ['groups' => ['Event-enclosure_read', 'Enclosure_read']])]
#[GetCollection(normalizationContext: ['groups' => ['Animal_Read_Enclosure']])]
#[Patch(security: "is_granted('ROLE_ADMIN')")]
#[Post(security: "is_granted('ROLE_ADMIN')")]
#[Get(
    uriTemplate: '/users/{id}/event',
    uriVariables: ['id' => new Link(fromProperty: 'enclosure', fromClass: Event::class)],
    normalizationContext: ['groups' => ['Event-enclosure_read']]
)]
class Enclosure
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['Animal_Read_Enclosure', 'Event-enclosure_read', 'Enclosure_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 128)]
    #[Groups(['Animal_Read_Enclosure', 'Event-enclosure_read', 'Enclosure_read'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'enclosure', targetEntity: Event::class, orphanRemoval: true)]
    #[Groups('Enclosure_read')]
    private Collection $events;

    #[ORM\OneToMany(mappedBy: 'enclosure', targetEntity: Animal::class)]
    #[Groups(['Enclosure_read', 'Animal_Read_Enclosure'])]
    private Collection $animals;

    public function __construct()
    {
        $this->events = new ArrayCollection();
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

    /**
     * @return Collection<int, Event>
     */
    public function getEvents(): Collection
    {
        return $this->events;
    }

    public function addEvent(Event $event): static
    {
        if (!$this->events->contains($event)) {
            $this->events->add($event);
            $event->setEnclosure($this);
        }

        return $this;
    }

    public function removeEvent(Event $event): static
    {
        if ($this->events->removeElement($event)) {
            // set the owning side to null (unless already changed)
            if ($event->getEnclosure() === $this) {
                $event->setEnclosure(null);
            }
        }

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
            $animal->setEnclosure($this);
        }

        return $this;
    }

    public function removeAnimal(Animal $animal): static
    {
        if ($this->animals->removeElement($animal)) {
            // set the owning side to null (unless already changed)
            if ($animal->getEnclosure() === $this) {
                $animal->setEnclosure(null);
            }
        }

        return $this;
    }
}
