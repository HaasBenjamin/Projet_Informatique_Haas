<?php

namespace App\Tests\Api\Animal;

use App\Factory\EnclosureFactory;
use App\Factory\SpeciesFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class AnimalPostCest
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
                '@id' => 'string',
                '@type' => 'string',
                'id' => 'integer:>0',
                'name' => 'string',
            ],
            'enclosure' => [
                '@id' => 'string',
                '@type' => 'string',
                'id' => 'integer:>0',
                'name' => 'string',
            ],
        ];
    }

    public function postAnimal(ApiTester $I): void
    {
        SpeciesFactory::createOne(['name' => 'UneChenillllleeee']);
        EnclosureFactory::createOne(['name' => 'LaCage']);
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        $I->amLoggedInAs($user);

        $I->sendPost('/api/animals', [
            'name' => 'Coin',
            'description' => 'Coin',
            'species' => '/api/species/1',
            'enclosure' => '/api/enclosures/1',
        ]);

        $I->seeResponseCodeIs(201);
        $I->seeResponseIsJson();

        $I->seeResponseMatchesJsonType($this->expectedProperties());

        $I->seeResponseContainsJson([
            'id' => 1,
            'name' => 'Coin',
            'description' => 'Coin',
            'species' => [
                '@id' => '/api/species/1',
                '@type' => 'Species',
                'id' => 1,
                'name' => 'UneChenillllleeee',
            ],
            'enclosure' => [
                '@id' => '/api/enclosures/1',
                '@type' => 'Enclosure',
                'id' => 1,
                'name' => 'LaCage',
            ],
        ]);
    }
}
