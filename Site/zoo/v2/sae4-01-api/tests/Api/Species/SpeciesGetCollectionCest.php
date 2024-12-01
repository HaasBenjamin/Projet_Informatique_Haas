<?php

namespace App\Tests\Api\Species;

use App\Entity\Species;
use App\Factory\SpeciesFactory;
use App\Tests\Support\ApiTester;

class SpeciesGetCollectionCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'description' => 'string',
            'family' => 'string',
            'animals' => 'array',
            'diet' => 'string',
            // 'image' => 'string',
        ];
    }

    public function getSpeciesCollection(ApiTester $I): void
    {
        SpeciesFactory::createMany(4);

        // 2. 'Act'
        $I->sendGet('/api/species');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsACollection(Species::class, '/api/species', [
            'hydra:member' => 'array',
            'hydra:totalItems' => 'integer',
        ]);
        $I->seeResponseContainsJson([
            'hydra:totalItems' => 4,
        ]);
        $I->seeResponseMatchesJsonType(self::expectedProperties(), '$["hydra:member"][0]');
    }
}
