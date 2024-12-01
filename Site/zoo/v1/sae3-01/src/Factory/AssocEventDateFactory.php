<?php

namespace App\Factory;

use App\Entity\AssocEventDate;
use App\Repository\AssocEventDateRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<AssocEventDate>
 *
 * @method        AssocEventDate|Proxy                     create(array|callable $attributes = [])
 * @method static AssocEventDate|Proxy                     createOne(array $attributes = [])
 * @method static AssocEventDate|Proxy                     find(object|array|mixed $criteria)
 * @method static AssocEventDate|Proxy                     findOrCreate(array $attributes)
 * @method static AssocEventDate|Proxy                     first(string $sortedField = 'id')
 * @method static AssocEventDate|Proxy                     last(string $sortedField = 'id')
 * @method static AssocEventDate|Proxy                     random(array $attributes = [])
 * @method static AssocEventDate|Proxy                     randomOrCreate(array $attributes = [])
 * @method static AssocEventDateRepository|RepositoryProxy repository()
 * @method static AssocEventDate[]|Proxy[]                 all()
 * @method static AssocEventDate[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static AssocEventDate[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static AssocEventDate[]|Proxy[]                 findBy(array $attributes)
 * @method static AssocEventDate[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static AssocEventDate[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class AssocEventDateFactory extends ModelFactory
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
            'eventDatesId' => EventDateFactory::random(),
            'eventId' => EventFactory::random(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(AssocEventDate $assocEventDate): void {})
        ;
    }

    protected static function getClass(): string
    {
        return AssocEventDate::class;
    }
}
