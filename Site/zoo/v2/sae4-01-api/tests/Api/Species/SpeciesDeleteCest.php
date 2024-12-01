<?php


namespace App\Tests\Api\Species;


use App\Factory\SpeciesFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class SpeciesDeleteCest
{
    public function DeleteSpecies(ApiTester $I): void
    {
        SpeciesFactory::createOne();
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        $I->amLoggedInAs($user);
        $I->sendDelete('/api/species/1');

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }
}
