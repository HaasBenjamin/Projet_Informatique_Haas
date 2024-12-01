<?php

namespace App\Tests\Api\AnimalFamily;

use App\Factory\AnimalCategoryFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class AnimalFamilyPostCest
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
            'category' => [
                '@id' => 'string',
                '@type' => 'string',
                'id' => 'integer:>0',
                'name' => 'string',
            ],
        ];
    }

    public function postAnimalFamily(ApiTester $I): void
    {
        $category = AnimalCategoryFactory::createOne(['name' => 'Formule1'])->object();
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        $I->amLoggedInAs($user);
        $I->sendPost('/api/animal_families', [
            'name' => 'MclarenBetter',
            'description' => 'tjrPasAucuneIdee',
            'category' => '/api/animal_categories/'.$category->getId(),
        ]);

        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $I->seeResponseMatchesJsonType($this->expectedProperties());

        $I->seeResponseContainsJson([
            'id' => 1,
            'name' => 'MclarenBetter',
            'description' => 'tjrPasAucuneIdee',
            'category' => [
                '@id' => '/api/animal_categories/'.$category->getId(),
                '@type' => 'AnimalCategory',
                'id' => $category->getId(),
                'name' => 'Formule1',
            ],
        ]);
    }
}
