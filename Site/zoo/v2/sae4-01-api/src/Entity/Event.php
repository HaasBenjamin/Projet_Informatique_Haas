<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: EventRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['Event_read']]
)]
#[Delete(
    normalizationContext: ['groups' => ['Event_write', 'Event_delete']],
    security: "is_granted('ROLE_ADMIN')"
)]
#[Get(
    normalizationContext: ['groups' => ['Event_read', 'Event-enclosure_read']]
)]
#[GetCollection(
    normalizationContext: ['groups' => ['Event_read', 'Event-enclosure_read']]
)]
#[Patch(
    normalizationContext: ['groups' => ['Event_write']],
    security: "is_granted('ROLE_ADMIN')"
)]
#[Post(
    security: "is_granted('ROLE_ADMIN')"
)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['Event_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 256)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 256)]
    #[Groups(['Event_read', 'Event_write', 'Event-registrations-read'])]
    private ?string $name = null;

    #[ORM\Column(length: 512)]
    #[Assert\NotBlank]
    #[Assert\Length(max: 512)]
    #[Groups(['Event_read', 'Event_write', 'Event-registrations-read'])]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Groups(['Event_read', 'Event_write', 'Event-registrations-read'])]
    private ?int $duration = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Groups(['Event_read', 'Event_write'])]
    private ?int $quota = null;

    #[ORM\ManyToOne(inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['Event_read', 'Event_write'])]
    private ?Enclosure $enclosure = null;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Registration::class, orphanRemoval: true)]
    #[Groups(['Event_read', 'Event_delete'])]
    private Collection $registrations;

    #[ORM\ManyToMany(targetEntity: EventDate::class, inversedBy: 'events')]
    #[Groups(['Event_read', 'Event_write'])]
    private Collection $eventDates;

    public function __construct()
    {
        $this->registrations = new ArrayCollection();
        $this->eventDates = new ArrayCollection();
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

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(int $duration): static
    {
        $this->duration = $duration;

        return $this;
    }

    public function getQuota(): ?int
    {
        return $this->quota;
    }

    public function setQuota(int $quota): static
    {
        $this->quota = $quota;

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

    /**
     * @return Collection<int, Registration>
     */
    public function getRegistrations(): Collection
    {
        return $this->registrations;
    }

    public function addRegistration(Registration $registration): static
    {
        if (!$this->registrations->contains($registration)) {
            $this->registrations->add($registration);
            $registration->setEvent($this);
        }

        return $this;
    }

    public function removeRegistration(Registration $registration): static
    {
        if ($this->registrations->removeElement($registration)) {
            // set the owning side to null (unless already changed)
            if ($registration->getEvent() === $this) {
                $registration->setEvent(null);
            }
        }

        return $this;
    }

    public function getNbRegisterSince(\DateTimeImmutable $date): int
    {
        $nbRegister = 0;
        foreach ($this->registrations as $registration) {
            $origin = new \DateTimeImmutable($registration->getDate()->format('Y-m-d H:i:s'));
            $interval = $date->diff($origin);
            if (0 == $interval->invert) {
                $nbRegister += $registration->getNbReservedPlaces();
            }
        }

        return $nbRegister;
    }

    public function getNbRegisterLeft(\DateTime $date): int
    {
        $nbRegister = 0;
        foreach ($this->registrations as $registration) {
            $origin = new \DateTime($registration->getDate()->format('Y-m-d'));
            if ($origin === $date) {
                $nbRegister += $registration->getNbReservedPlaces();
            }
        }

        return $this->quota - $nbRegister;
    }

    /**
     * @return Collection<int, EventDate>
     */
    public function getEventDates(): Collection
    {
        return $this->eventDates;
    }

    public function addEventDate(EventDate $eventDate): static
    {
        if (!$this->eventDates->contains($eventDate)) {
            $this->eventDates->add($eventDate);
        }

        return $this;
    }

    public function removeEventDate(EventDate $eventDate): static
    {
        $this->eventDates->removeElement($eventDate);

        return $this;
    }
}
