<?php

namespace App\Factory;

use App\Entity\Enclosure;
use App\Repository\EnclosureRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Enclosure>
 *
 * @method        Enclosure|Proxy                     create(array|callable $attributes = [])
 * @method static Enclosure|Proxy                     createOne(array $attributes = [])
 * @method static Enclosure|Proxy                     find(object|array|mixed $criteria)
 * @method static Enclosure|Proxy                     findOrCreate(array $attributes)
 * @method static Enclosure|Proxy                     first(string $sortedField = 'id')
 * @method static Enclosure|Proxy                     last(string $sortedField = 'id')
 * @method static Enclosure|Proxy                     random(array $attributes = [])
 * @method static Enclosure|Proxy                     randomOrCreate(array $attributes = [])
 * @method static EnclosureRepository|RepositoryProxy repository()
 * @method static Enclosure[]|Proxy[]                 all()
 * @method static Enclosure[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static Enclosure[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static Enclosure[]|Proxy[]                 findBy(array $attributes)
 * @method static Enclosure[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static Enclosure[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class EnclosureFactory extends ModelFactory
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
        return $this
            // ->afterInstantiate(function(Enclosure $enclos): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Enclosure::class;
    }
}
