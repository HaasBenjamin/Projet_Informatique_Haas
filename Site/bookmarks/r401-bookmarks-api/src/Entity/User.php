<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use App\Controller\GetAvatarController;
use App\Repository\UserRepository;
use App\State\MeProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(operations: [new Get(
    uriTemplate: '/me',
    openapiContext: [
        'summary' => 'Retrieves the connected user',
        'description' => 'Retrieves the connected user',
        'responses' => [
            '200' => [
                'description' => 'connected user resource',
                'content' => [
                    'application/ld+json' => [
                        'schema' => [
                            '$ref' => '#/components/schemas/User.jsonld-User_me_User_read',
                        ],
                    ],
                ],
            ],
        ],
    ],
    normalizationContext: ['groups' => ['User_me', 'User_read']],
    security: 'user',
    provider: MeProvider::class),
    new Get(
        uriTemplate: '/users/{id}/avatar',
        formats: [
            'png' => 'image/png',
        ],
        controller: GetAvatarController::class,
        openapiContext: [
            'responses' => [
                '200' => [
                    'content' => [
                        'image/png' => [
                            'schema' => [
                                'type' => 'string',
                                'format' => 'binary',
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ),
    ]
)]
#[Get(normalizationContext: ['groups' => ['User_read']])]
#[Patch(normalizationContext: ['groups' => ['User_me', 'User_read']], denormalizationContext: ['groups' => ['User_write']], security: 'user and object.getId()==user.getId()')]
#[UniqueEntity('login')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups('User_read')]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Assert\Regex(
        pattern: '/^\w+/',
        message: 'Your firstname contains forbidden characters',
    )]
    #[ApiProperty(example: 'user001')]
    #[Groups(['User_read', 'User_write'])]
    private ?string $login = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups('User_write')]
    private ?string $password = null;

    #[ORM\Column(length: 30)]
    #[Assert\Regex(
        pattern: '/^\w+/',
        message: 'Your firstname contains forbidden characters',
    )]
    #[ApiProperty(example: 'Benjamin')]
    #[Groups(['User_read', 'User_write'])]
    private ?string $firstname = null;

    #[ORM\Column(length: 40)]
    #[Assert\Regex(
        pattern: '/^\w+/',
        message: 'Your firstname contains forbidden characters',
    )]
    #[ApiProperty(example: 'haas')]
    #[Groups(['User_read', 'User_write'])]
    private ?string $lastname = null;

    #[ORM\Column(type: Types::BLOB)]
    private $avatar;

    #[Assert\Email(
        message: 'The email {{ value }} is not a valid email.',
    )]
    #[ORM\Column(length: 100)]
    #[Groups(['User_me', 'User_write'])]
    private ?string $email = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Rating::class, orphanRemoval: true)]
    private Collection $ratings;

    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: Bookmark::class, orphanRemoval: true)]
    private Collection $bookmarks;

    public function __construct()
    {
        $this->ratings = new ArrayCollection();
        $this->bookmarks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): static
    {
        $this->login = $login;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->login;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

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
            $rating->setUser($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): static
    {
        if ($this->ratings->removeElement($rating)) {
            // set the owning side to null (unless already changed)
            if ($rating->getUser() === $this) {
                $rating->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Bookmark>
     */
    public function getBookmarks(): Collection
    {
        return $this->bookmarks;
    }

    public function addBookmark(Bookmark $bookmark): static
    {
        if (!$this->bookmarks->contains($bookmark)) {
            $this->bookmarks->add($bookmark);
            $bookmark->setOwner($this);
        }

        return $this;
    }

    public function removeBookmark(Bookmark $bookmark): static
    {
        if ($this->bookmarks->removeElement($bookmark)) {
            // set the owning side to null (unless already changed)
            if ($bookmark->getOwner() === $this) {
                $bookmark->setOwner(null);
            }
        }

        return $this;
    }
}
