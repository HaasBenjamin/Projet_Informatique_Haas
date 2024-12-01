<?php

namespace App\Tests\Api\Species;

use App\Entity\Species;
use App\Factory\AnimalDietFactory;
use App\Factory\AnimalFamilyFactory;
use App\Factory\ImageFactory;
use App\Factory\SpeciesFactory;
use App\Tests\Support\ApiTester;

class SpeciesGetCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'description' => 'string',
            'family' => 'string',
            'animals' => 'array',
            'image' => 'string',
            'diet' => 'string',
        ];
    }

    public function getSpecies(ApiTester $I): void
    {
        AnimalFamilyFactory::createOne();
        AnimalDietFactory::createOne();
        ImageFactory::createOne();
        $data = [
            'name' => 'species',
            'description' => 'species desc',
            'family' => '/api/animal_families/1',
            'diet' => '/api/animal_diets/1',
            'image' => '/api/images/1',
            'animals' => [],
        ];
        $I->sendPost('/api/species', $data);

        $I->sendGet('/api/species/1');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Species::class, '/api/species/1');
        $I->seeResponseIsAnItem(self::expectedProperties(), $data);
    }
}
