<?php


namespace App\Tests\Api\Animal;

use App\Factory\AnimalFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class AnimalDeleteCest
{
    public function AnimalDelete(ApiTester $I)
    {
        AnimalFactory::createOne();
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        $I->amLoggedInAs($user);
        $I->sendDelete('/api/animals/1');
        $I->seeResponseCodeIs(204);
    }

}
