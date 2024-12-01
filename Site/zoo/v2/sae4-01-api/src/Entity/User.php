<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
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

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user')]
#[ApiResource]
#[Get]
#[Get(uriTemplate: '/me',
    openapiContext: [
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
        'summary' => 'Retrieves the connected user',
        'description' => 'Retrieves the connected user',
    ],
    normalizationContext: ['groups' => ['User_me', 'User_read']],
    provider: MeProvider::class),]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['User_read','User-registrations_read'])]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    #[Groups(['User_read', 'User_write', 'Event-registrations-read'])]
    private ?string $email = null;

    #[ORM\Column]
    #[Groups(['User_read'])]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['User_write'])]
    private ?string $password = null;

    #[ORM\Column(length: 128)]
    #[Groups(['User_read', 'User_write', 'Event-registrations-read'])]
    private ?string $lastname = null;

    #[ORM\Column(length: 128)]
    #[Groups(['User_read', 'User_write', 'Event-registrations-read'])]
    private ?string $firstname = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['Event-registrations-read'])]
    private ?\DateTimeInterface $dateOfBirth = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $hiringDate = null;

    #[ORM\Column(nullable: true)]
    private ?int $contractDuration = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateVisitor = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Registration::class, orphanRemoval: true)]
    private Collection $registrations;

    public function __construct()
    {
        $this->registrations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
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

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
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

    public function getDateOfBirth(): ?\DateTimeInterface
    {
        return $this->dateOfBirth;
    }

    public function setDateOfBirth(\DateTimeInterface $dateOfBirth): static
    {
        $this->dateOfBirth = $dateOfBirth;

        return $this;
    }

    public function getHiringDate(): ?\DateTimeInterface
    {
        return $this->hiringDate;
    }

    public function setHiringDate(?\DateTimeInterface $hiringDate): static
    {
        $this->hiringDate = $hiringDate;

        return $this;
    }

    public function getContractDuration(): ?int
    {
        return $this->contractDuration;
    }

    public function setContractDuration(?int $contractDuration): static
    {
        $this->contractDuration = $contractDuration;

        return $this;
    }

    public function getDateVisitor(): ?\DateTimeInterface
    {
        return $this->dateVisitor;
    }

    public function setDateVisitor(?\DateTimeInterface $dateVisitor): static
    {
        $this->dateVisitor = $dateVisitor;

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
            $registration->setUser($this);
        }

        return $this;
    }

    public function removeRegistration(Registration $registration): static
    {
        if ($this->registrations->removeElement($registration)) {
            // set the owning side to null (unless already changed)
            if ($registration->getUser() === $this) {
                $registration->setUser(null);
            }
        }

        return $this;
    }
}
