<?php

namespace App\Factory;

use App\Entity\AnimalCategory;
use App\Repository\AnimalCategoryRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<AnimalCategory>
 *
 * @method        AnimalCategory|Proxy                     create(array|callable $attributes = [])
 * @method static AnimalCategory|Proxy                     createOne(array $attributes = [])
 * @method static AnimalCategory|Proxy                     find(object|array|mixed $criteria)
 * @method static AnimalCategory|Proxy                     findOrCreate(array $attributes)
 * @method static AnimalCategory|Proxy                     first(string $sortedField = 'id')
 * @method static AnimalCategory|Proxy                     last(string $sortedField = 'id')
 * @method static AnimalCategory|Proxy                     random(array $attributes = [])
 * @method static AnimalCategory|Proxy                     randomOrCreate(array $attributes = [])
 * @method static AnimalCategoryRepository|RepositoryProxy repository()
 * @method static AnimalCategory[]|Proxy[]                 all()
 * @method static AnimalCategory[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static AnimalCategory[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static AnimalCategory[]|Proxy[]                 findBy(array $attributes)
 * @method static AnimalCategory[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static AnimalCategory[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class AnimalCategoryFactory extends ModelFactory
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
            'description' => self::faker()->text(50),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this;
    }

    protected static function getClass(): string
    {
        return AnimalCategory::class;
    }
}
