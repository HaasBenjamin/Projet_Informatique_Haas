<?php

declare(strict_types=1);

namespace Api\AnimalCategory;

use App\Factory\AnimalCategoryFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class AnimalCategoryDeleteCest
{
    public function seeWhenAnimalCategoryIsDeletedCategroyIsRemoved(ApiTester $I)
    {
        AnimalCategoryFactory::createOne();
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        $I->amLoggedInAs($user);
        $I->sendDelete('/api/animal_categories/1');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }
}
