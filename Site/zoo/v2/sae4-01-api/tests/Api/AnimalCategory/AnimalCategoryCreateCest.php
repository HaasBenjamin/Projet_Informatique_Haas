<?php

declare(strict_types=1);

namespace Api\AnimalCategory;

use App\Entity\AnimalCategory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class AnimalCategoryCreateCest
{
    public function seeWhenAnimalCategoryIsCreatedDataIsPersisted(ApiTester $I)
    {
        $dataCategory = [
            'name' => 'Poisson',
            'description' => 'description',
        ];
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        $I->amLoggedInAs($user);
        $I->sendPost('/api/animal_categories', $dataCategory);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->sendGet('/api/animal_categories/1');
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();
        $I->SeeResponseIsAnEntity(AnimalCategory::class, '/api/animal_categories/1');
        $I->seeResponseContainsJson([
            'name' => 'Poisson',
            'description' => 'description',
        ]);
    }
}
