<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\OpenApi\Model;
use App\Controller\GetImageController;
use App\Controller\PatchImageAction;
use App\Controller\PostImageAction;
use App\Repository\ImageRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImageRepository::class)]
#[ApiResource]
#[Delete]
#[GetCollection]
#[Post(inputFormats: ['multipart' => ['multipart/form-data']],
    controller: PostImageAction::class,
    openapi: new Model\Operation(
        summary: 'Add a picture to the zoo',
        requestBody: new Model\RequestBody(
            content: new \ArrayObject([
                'multipart/form-data' => [
                    'schema' => [
                        'type' => 'object',
                        'properties' => [
                            'image' => ['type' => 'string', 'format' => 'binary'],
                            'animals' => ['type' => 'array'],
                            'species' => ['type' => 'array'],
                            'AnimalsCategory' => ['type' => 'array'],
                            'AnimalsFamily' => ['type' => 'array'],
                        ],
                    ],
                ],
            ])
        )
    ), deserialize: false,
)]
#[Get(
    uriTemplate: '/images/{id}',
    formats: [
        'png' => 'image/png',
    ],
    controller: GetImageController::class,
    openapiContext: [
        'responses' => [
            '200' => [
                'description' => 'image ressource',
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
    ]
),]
class Image
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BLOB)]
    #[ApiProperty(
        openapiContext: [
            'type' => 'string',
            'format' => 'binary',
        ]
    )]
    private $image;

    #[ORM\OneToMany(mappedBy: 'image', targetEntity: Animal::class)]
    private Collection $animals;

    #[ORM\OneToMany(mappedBy: 'image', targetEntity: Species::class)]
    private Collection $species;

    #[ORM\OneToMany(mappedBy: 'image', targetEntity: AnimalCategory::class)]
    private Collection $AnimalsCategory;

    #[ORM\OneToMany(mappedBy: 'image', targetEntity: AnimalFamily::class)]
    private Collection $AnimalsFamily;

    public function __construct()
    {
        $this->animals = new ArrayCollection();
        $this->species = new ArrayCollection();
        $this->AnimalsCategory = new ArrayCollection();
        $this->AnimalsFamily = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImage()
    {
        return $this->image;
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

    /**
     * @return Collection<int, AnimalCategory>
     */
    public function getAnimalsCategory(): Collection
    {
        return $this->AnimalsCategory;
    }

    public function addAnimalsCategory(AnimalCategory $animalsCategory): static
    {
        if (!$this->AnimalsCategory->contains($animalsCategory)) {
            $this->AnimalsCategory->add($animalsCategory);
            $animalsCategory->setImage($this);
        }

        return $this;
    }

    public function removeAnimalsCategory(AnimalCategory $animalsCategory): static
    {
        if ($this->AnimalsCategory->removeElement($animalsCategory)) {
            // set the owning side to null (unless already changed)
            if ($animalsCategory->getImage() === $this) {
                $animalsCategory->setImage(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AnimalFamily>
     */
    public function getAnimalsFamily(): Collection
    {
        return $this->AnimalsFamily;
    }

    public function addAnimalsFamily(AnimalFamily $animalsFamily): static
    {
        if (!$this->AnimalsFamily->contains($animalsFamily)) {
            $this->AnimalsFamily->add($animalsFamily);
            $animalsFamily->setImage($this);
        }

        return $this;
    }

    public function removeAnimalsFamily(AnimalFamily $animalsFamily): static
    {
        if ($this->AnimalsFamily->removeElement($animalsFamily)) {
            // set the owning side to null (unless already changed)
            if ($animalsFamily->getImage() === $this) {
                $animalsFamily->setImage(null);
            }
        }

        return $this;
    }
}
