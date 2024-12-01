<?php

namespace App\Factory;

use App\Entity\AnimalDiet;
use App\Repository\AnimalDietRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<AnimalDiet>
 *
 * @method        AnimalDiet|Proxy               create(array|callable $attributes = [])
 * @method static AnimalDiet|Proxy               createOne(array $attributes = [])
 * @method static AnimalDiet|Proxy               find(object|array|mixed $criteria)
 * @method static AnimalDiet|Proxy               findOrCreate(array $attributes)
 * @method static AnimalDiet|Proxy               first(string $sortedField = 'id')
 * @method static AnimalDiet|Proxy               last(string $sortedField = 'id')
 * @method static AnimalDiet|Proxy               random(array $attributes = [])
 * @method static AnimalDiet|Proxy               randomOrCreate(array $attributes = [])
 * @method static AnimalDietRepository|RepositoryProxy repository()
 * @method static AnimalDiet[]|Proxy[]           all()
 * @method static AnimalDiet[]|Proxy[]           createMany(int $number, array|callable $attributes = [])
 * @method static AnimalDiet[]|Proxy[]           createSequence(iterable|callable $sequence)
 * @method static AnimalDiet[]|Proxy[]           findBy(array $attributes)
 * @method static AnimalDiet[]|Proxy[]           randomRange(int $min, int $max, array $attributes = [])
 * @method static AnimalDiet[]|Proxy[]           randomSet(int $number, array $attributes = [])
 */
final class AnimalDietFactory extends ModelFactory
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
     */
    protected function getDefaults(): array
    {
        return [
            'name' => self::faker()->word(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this// ->afterInstantiate(function(AnimalDiet $regime): void {})
            ;
    }

    protected static function getClass(): string
    {
        return AnimalDiet::class;
    }
}
