<?php

declare(strict_types=1);

namespace Api\AnimalCategory;

use App\Factory\AnimalCategoryFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class AnimalCategoryPatchCest
{
    public function seeWhenAnimalCategoryIsPatchDataIsUpdated(ApiTester $I)
    {
        AnimalCategoryFactory::createOne();
        $dataCategory = [
            'name' => 'poisson',
        ];
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        $I->amLoggedInAs($user);
        $I->sendPatch('/api/animal_categories/1', $dataCategory);
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->seeResponseContainsJson([
            'name' => 'poisson',
            ]);
    }
}
