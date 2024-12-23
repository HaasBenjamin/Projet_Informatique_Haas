<?php

namespace App\Factory;

use App\Entity\Species;
use App\Factory\AnimalFamilyFactory;
use App\Factory\AnimalDietFactory;
use App\Repository\SpeciesRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Species>
 *
 * @method        Species|Proxy create(array|callable $attributes = [])
 * @method static Species|Proxy createOne(array $attributes = [])
 * @method static Species|Proxy find(object|array|mixed $criteria)
 * @method static Species|Proxy findOrCreate(array $attributes)
 * @method static Species|Proxy first(string $sortedField = 'id')
 * @method static Species|Proxy last(string $sortedField = 'id')
 * @method static Species|Proxy random(array $attributes = [])
 * @method static Species|Proxy randomOrCreate(array $attributes = [])
 * @method static SpeciesRepository|RepositoryProxy repository()
 * @method static Species[]|Proxy[] all()
 * @method static Species[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Species[]|Proxy[] createSequence(iterable|callable $sequence)
 * @method static Species[]|Proxy[] findBy(array $attributes)
 * @method static Species[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static Species[]|Proxy[] randomSet(int $number, array $attributes = [])
 */
final class SpeciesFactory extends ModelFactory
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
            'description' => self::faker()->text(50),
            'family' => AnimalFamilyFactory::new(),
            'name' => self::faker()->word(),
            'diet' => AnimalDietFactory::new(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(Species $species): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Species::class;
    }
}
