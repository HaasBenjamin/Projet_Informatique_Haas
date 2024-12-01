<?php

namespace App\Factory;

use App\Entity\Image;
use App\Repository\ImageRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Image>
 *
 * @method        Image|Proxy create(array|callable $attributes = [])
 * @method static Image|Proxy createOne(array $attributes = [])
 * @method static Image|Proxy find(object|array|mixed $criteria)
 * @method static Image|Proxy findOrCreate(array $attributes)
 * @method static Image|Proxy first(string $sortedField = 'id')
 * @method static Image|Proxy last(string $sortedField = 'id')
 * @method static Image|Proxy random(array $attributes = [])
 * @method static Image|Proxy randomOrCreate(array $attributes = [])
 * @method static ImageRepository|RepositoryProxy repository()
 * @method static Image[]|Proxy[] all()
 * @method static Image[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Image[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Image[]|Proxy[] findBy(array $attributes)
 * @method static Image[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Image[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class ImageFactory extends ModelFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function getDefaults(): array
    {
        return [
            // 'image' => file_get_contents(self::faker()->image()),
            'image' => file_get_contents("https://www.google.com/url?sa=i&url=https%3A%2F%2Fthenounproject.com%2Fbrowse%2Ficons%2Fterm%2Fno-item%2F&psig=AOvVaw1AHl4id6wH6OdW4nZd9-18&ust=1709400869587000&source=images&cd=vfe&opi=89978449&ved=0CBIQjRxqFwoTCLDJss7M04QDFQAAAAAdAAAAABAE"),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Image $image): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Image::class;
    }
}
