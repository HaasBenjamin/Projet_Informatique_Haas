<?php

namespace App\Tests\Api\AnimalFamily;

use App\Factory\AnimalFamilyFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class AnimalFamilyDeleteCest
{
    public function AnimalFamilyDelete(ApiTester $I)
    {
        AnimalFamilyFactory::createOne();
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        $I->amLoggedInAs($user);
        $I->sendDelete('/api/animal_families/1');
        $I->seeResponseCodeIs(204);
    }
}
