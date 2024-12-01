<?php

namespace App\Tests\Api\Animal;

use App\Entity\Animal;
use App\Factory\AnimalFactory;
use App\Factory\EnclosureFactory;
use App\Factory\SpeciesFactory;
use App\Tests\Support\ApiTester;

class AnimalGetCollectionCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'description' => 'string',
            'species' => 'array',
            'enclosure' => 'array',
        ];
    }

    public function getAnimalCollection(ApiTester $I): void
    {
        AnimalFactory::createMany(4);

        // 2. 'Act'
        $I->sendGet('/api/animals');

        // 3. 'Assert'
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsACollection(Animal::class, '/api/animals', [
            'hydra:member' => 'array',
            'hydra:totalItems' => 'integer',
        ]);
        $I->seeResponseContainsJson([
            'hydra:totalItems' => 4,
        ]);
        $I->seeResponseMatchesJsonType(self::expectedProperties(), '$["hydra:member"][0]');
    }

    public function getCollectionAnimalByEnclosures(ApiTester $I): void
    {
        $specie = SpeciesFactory::createOne(['name' => 'UneChenillllleeee'])->object();
        $enclosure = EnclosureFactory::createOne(['name' => 'LaCage'])->object();

        $animal = AnimalFactory::createOne([
            'name' => 'Coin',
            'description' => 'Coin',
            'enclosure' => $enclosure,
            'species' => $specie,
        ])->object();

        $animal2 = AnimalFactory::createOne([
            'name' => 'CoinCoin',
            'description' => 'CoinCoin',
            'enclosure' => $enclosure,
            'species' => $specie,
        ])->object();

        $I->sendGet('/api/enclosures/1/animals');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'id' => $animal->getId(),
            'name' => 'Coin',
            'description' => 'Coin',
            'species' => [
                '@id' => '/api/species/1',
                '@type' => 'Species',
                'id' => 1,
                'name' => 'UneChenillllleeee',
            ],
        ]);

        $I->seeResponseContainsJson([
            'id' => $animal2->getId(),
            'name' => 'CoinCoin',
            'description' => 'CoinCoin',
            'species' => [
                '@id' => '/api/species/1',
                '@type' => 'Species',
                'id' => 1,
                'name' => 'UneChenillllleeee',
            ],
        ]);
    }

    public function getCollectionAnimalBySpecies(ApiTester $I): void
    {
        $specie = SpeciesFactory::createOne(['name' => 'UneChenillllleeee'])->object();
        $enclosure = EnclosureFactory::createOne(['name' => 'LaCage'])->object();

        $animal = AnimalFactory::createOne([
            'name' => 'Coin',
            'description' => 'Coin',
            'enclosure' => $enclosure,
            'species' => $specie,
        ])->object();

        $animal2 = AnimalFactory::createOne([
            'name' => 'CoinCoin',
            'description' => 'CoinCoin',
            'enclosure' => $enclosure,
            'species' => $specie,
        ])->object();

        $I->sendGet('/api/species/1/animals');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'id' => $animal->getId(),
            'name' => 'Coin',
            'description' => 'Coin',
            'enclosure' => [
                '@id' => '/api/enclosures/1',
                '@type' => 'Enclosure',
                'id' => 1,
                'name' => 'LaCage',
            ],
        ]);

        $I->seeResponseContainsJson([
            'id' => $animal2->getId(),
            'name' => 'CoinCoin',
            'description' => 'CoinCoin',
            'enclosure' => [
                '@id' => '/api/enclosures/1',
                '@type' => 'Enclosure',
                'id' => 1,
                'name' => 'LaCage',
            ],
        ]);
    }
}
