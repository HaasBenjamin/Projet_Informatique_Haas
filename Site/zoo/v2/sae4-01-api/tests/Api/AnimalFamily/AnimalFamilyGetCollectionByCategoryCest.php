<?php

namespace App\Tests\Api\AnimalFamily;

use App\Factory\AnimalCategoryFactory;
use App\Factory\AnimalFamilyFactory;
use App\Tests\Support\ApiTester;

class AnimalFamilyGetCollectionByCategoryCest
{
    public function getCollectionByCategoryAnimalFamily(ApiTester $I): void
    {
        $category = AnimalCategoryFactory::createOne(['name' => 'Formule1'])->object();

        $animalFamily = AnimalFamilyFactory::createOne([
            'name' => 'MclarenBetter',
            'description' => 'tjrPasAucuneIdee',
            'category' => $category,
        ])->object();

        $animalFamily2 = AnimalFamilyFactory::createOne([
            'name' => 'Eugène',
            'description' => 'Sinistre',
            'category' => $category,
        ])->object();

        $I->sendGet('/api/animal_categories/1/animal_families');

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
