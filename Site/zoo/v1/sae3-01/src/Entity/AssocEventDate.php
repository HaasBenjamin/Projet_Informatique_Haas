<?php

namespace App\Entity;

use App\Repository\AssocEventDateRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssocEventDateRepository::class)]
class AssocEventDate
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'eventDates')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $eventId = null;

    #[ORM\ManyToOne(cascade: ['persist'], inversedBy: 'events')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EventDate $eventDatesId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventId(): ?Event
    {
        return $this->eventId;
    }

    public function setEventId(?Event $eventId): static
    {
        $this->eventId = $eventId;

        return $this;
    }

    public function getEventDatesId(): ?EventDate
    {
        return $this->eventDatesId;
    }

    public function setEventDatesId(?EventDate $eventDatesId): static
    {
        $this->eventDatesId = $eventDatesId;

        return $this;
    }
}
