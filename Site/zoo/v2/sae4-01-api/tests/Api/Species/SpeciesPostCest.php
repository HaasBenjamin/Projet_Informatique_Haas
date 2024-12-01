<?php

namespace App\Tests\Api\Species;

use App\Factory\AnimalDietFactory;
use App\Factory\AnimalFamilyFactory;
use App\Factory\ImageFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class SpeciesPostCest
{
    public function PostSpecies(ApiTester $I): void
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
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        $I->amLoggedInAs($user);
        $I->sendPost('/api/species', $data);
        $I->seeResponseCodeIsSuccessful();
    }
}
