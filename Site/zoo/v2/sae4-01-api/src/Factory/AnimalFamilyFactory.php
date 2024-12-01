<?php

namespace App\Factory;

use App\Entity\AnimalFamily;
use App\Repository\AnimalFamilyRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<AnimalFamily>
 *
 * @method        AnimalFamily|Proxy                     create(array|callable $attributes = [])
 * @method static AnimalFamily|Proxy                     createOne(array $attributes = [])
 * @method static AnimalFamily|Proxy                     find(object|array|mixed $criteria)
 * @method static AnimalFamily|Proxy                     findOrCreate(array $attributes)
 * @method static AnimalFamily|Proxy                     first(string $sortedField = 'id')
 * @method static AnimalFamily|Proxy                     last(string $sortedField = 'id')
 * @method static AnimalFamily|Proxy                     random(array $attributes = [])
 * @method static AnimalFamily|Proxy                     randomOrCreate(array $attributes = [])
 * @method static AnimalFamilyRepository|RepositoryProxy repository()
 * @method static AnimalFamily[]|Proxy[]                 all()
 * @method static AnimalFamily[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static AnimalFamily[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static AnimalFamily[]|Proxy[]                 findBy(array $attributes)
 * @method static AnimalFamily[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static AnimalFamily[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class AnimalFamilyFactory extends ModelFactory
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
            'category' => AnimalCategoryFactory::new(),
            'description' => self::faker()->text(50),
            'name' => self::faker()->word(),
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
        return AnimalFamily::class;
    }
}