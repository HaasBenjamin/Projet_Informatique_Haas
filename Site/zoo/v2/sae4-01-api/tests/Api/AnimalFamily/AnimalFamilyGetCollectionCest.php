<?php

namespace App\Tests\Api\AnimalFamily;

use App\Factory\AnimalFamilyFactory;
use App\Tests\Support\ApiTester;

class AnimalFamilyGetCollectionCest
{
    public function getCollectionAnimalFamily(ApiTester $I): void
    {
        $animalFamily = AnimalFamilyFactory::createOne([
            'name' => 'MclarenBetter',
            'description' => 'tjrPasAucuneIdee',
        ])->object();

        $animalFamily2 = AnimalFamilyFactory::createOne([
            'name' => 'Eugène',
            'description' => 'Sinistre',
        ])->object();

        $I->sendGet('/api/animal_families');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();

        $I->seeResponseContainsJson([
            'id' => $animalFamily->getId(),
            'name' => 'MclarenBetter',
            'description' => 'tjrPasAucuneIdee',
        ]);

        $I->seeResponseContainsJson([
            'id' => $animalFamily2->getId(),
            'name' => 'Eugène',
            'description' => 'Sinistre',
        ]);
    }
}
