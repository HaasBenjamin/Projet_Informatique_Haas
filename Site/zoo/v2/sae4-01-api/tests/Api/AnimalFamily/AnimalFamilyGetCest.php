<?php

namespace App\Tests\Api\AnimalFamily;

use App\Factory\AnimalCategoryFactory;
use App\Factory\AnimalFamilyFactory;
use App\Factory\SpeciesFactory;
use App\Tests\Support\ApiTester;

class AnimalFamilyGetCest
{
    protected static function expectedProperties(): array
    {
        return [
            '@context' => 'string',
            '@id' => 'string',
            '@type' => 'string',
            'id' => 'integer:>0',
            'name' => 'string',
            'description' => 'string',
            'species' => [
                [
                    '@id' => 'string',
                    '@type' => 'string',
                    'id' => 'integer:>0',
                    'name' => 'string',
                ],
            ],
            'category' => [
                '@id' => 'string',
                '@type' => 'string',
                'id' => 'integer:>0',
                'name' => 'string',
            ],
        ];
    }

    public function getAnimalFamily(ApiTester $I): void
    {
        $category = AnimalCategoryFactory::createOne(['name' => 'Formule1'])->object();

        $animalFamily = AnimalFamilyFactory::createOne([
            'name' => 'MclarenBetter',
            'description' => 'tjrPasAucuneIdee',
            'category' => $category,
        ])->object();

        $species = SpeciesFactory::createOne(['family' => $animalFamily])->object();

        $I->sendGet('/api/animal_families/1');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();

        $I->seeResponseMatchesJsonType($this->expectedProperties());

        $I->seeResponseContainsJson([
            'id' => $animalFamily->getId(),
            'name' => 'MclarenBetter',
            'description' => 'tjrPasAucuneIdee',
            'species' => [
                [
                    '@id' => '/api/species/'.$species->getId(),
                    '@type' => 'Species',
                    'id' => $species->getId(),
                    'name' => $species->getName(),
                ],
            ],
            'category' => [
                '@id' => '/api/animal_categories/'.$category->getId(),
                '@type' => 'AnimalCategory',
                'id' => $category->getId(),
                'name' => 'Formule1',
            ],
        ]);
    }
}
