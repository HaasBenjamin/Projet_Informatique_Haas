<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\BooleanFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use App\Repository\BookmarkRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: BookmarkRepository::class)]
#[ApiResource(order: ['name' => 'ASC'])]
#[GetCollection(normalizationContext: ['groups' => ['Bookmark_read']])]
#[Post(normalizationContext: ['groups' => ['Bookmark_detail']], denormalizationContext: ['groups' => ['Bookmark_write']], security: 'user')]
#[Get(normalizationContext: ['groups' => ['Bookmark_detail', 'Bookmark_read']])]
#[Delete(security: 'user && object.getOwner().getId()==user.getId()')]
#[Patch(normalizationContext: ['groups' => ['Bookmark_detail']], denormalizationContext: ['groups' => ['Bookmark_write']])]
#[ApiFilter(OrderFilter::class, properties: ['name' => 'ASC', 'creationDate' => 'ASC'])]
#[ApiFilter(BooleanFilter::class, properties: ['isPublic'])]
#[ApiFilter(SearchFilter::class, properties: ['name' => 'partial', 'description' => 'partial'])]
#[ORM\HasLifecycleCallbacks]
class Bookmark
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['User-rating_read', 'Bookmark_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['User-rating_read', 'Bookmark_read', 'Bookmark_write'])]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['Bookmark_detail', 'Bookmark_write'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups('Bookmark_detail')]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\Column]
    #[Groups(['Bookmark_read', 'Bookmark_write'])]
    private ?bool $isPublic = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\Url]
    #[Groups(['Bookmark_read', 'Bookmark_write'])]
    private ?string $url = null;

    #[ORM\OneToMany(mappedBy: 'bookmark', targetEntity: Rating::class, orphanRemoval: true)]
    #[Groups(['Bookmark_read'])]
    private Collection $ratings;

    #[ORM\Column(type: Types::FLOAT, options: ['default' => 0.0])]
    #[Groups(['Bookmark_read'])]
    private ?float $rateAverage = 0.0;

    #[ORM\ManyToOne(inversedBy: 'bookmarks')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['Bookmark_write'])]
    private ?User $owner = null;

    public function __construct()
    {
        $this->ratings = new ArrayCollection();
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

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): static
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function isIsPublic(): ?bool
    {
        return $this->isPublic;
    }

    public function setIsPublic(bool $isPublic): static
    {
        $this->isPublic = $isPublic;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return Collection<int, Rating>
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): static
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings->add($rating);
            $rating->setBookmark($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): static
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getBookmark() === $this) {
                $rating->setBookmark(null);
            }
        }

        return $this;
    }

    #[ORM\PrePersist]
    public function setCreatedAtValue(): void
    {
        if (!isset($this->creationDate) || null == $this->creationDate) {
            $this->creationDate = new \DateTimeImmutable();
        }
    }

    public function getRateAverage(): ?float
    {
        return $this->rateAverage;
    }

    public function setRateAverage(float $rateAverage): static
    {
        $this->rateAverage = $rateAverage;

        return $this;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }
}
