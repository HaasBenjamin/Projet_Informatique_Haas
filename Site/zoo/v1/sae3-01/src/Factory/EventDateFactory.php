<?php

namespace App\Factory;

use App\Entity\EventDate;
use App\Repository\EventDateRepository;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<EventDate>
 *
 * @method        EventDate|Proxy                     create(array|callable $attributes = [])
 * @method static EventDate|Proxy                     createOne(array $attributes = [])
 * @method static EventDate|Proxy                     find(object|array|mixed $criteria)
 * @method static EventDate|Proxy                     findOrCreate(array $attributes)
 * @method static EventDate|Proxy                     first(string $sortedField = 'id')
 * @method static EventDate|Proxy                     last(string $sortedField = 'id')
 * @method static EventDate|Proxy                     random(array $attributes = [])
 * @method static EventDate|Proxy                     randomOrCreate(array $attributes = [])
 * @method static EventDateRepository|RepositoryProxy repository()
 * @method static EventDate[]|Proxy[]                 all()
 * @method static EventDate[]|Proxy[]                 createMany(int $number, array|callable $attributes = [])
 * @method static EventDate[]|Proxy[]                 createSequence(iterable|callable $sequence)
 * @method static EventDate[]|Proxy[]                 findBy(array $attributes)
 * @method static EventDate[]|Proxy[]                 randomRange(int $min, int $max, array $attributes = [])
 * @method static EventDate[]|Proxy[]                 randomSet(int $number, array $attributes = [])
 */
final class EventDateFactory extends ModelFactory
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
            'date' => self::faker()->dateTime(),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): self
    {
        return $this
            // ->afterInstantiate(function(EventDate $eventDate): void {})
        ;
    }

    protected static function getClass(): string
    {
        return EventDate::class;
    }
}
