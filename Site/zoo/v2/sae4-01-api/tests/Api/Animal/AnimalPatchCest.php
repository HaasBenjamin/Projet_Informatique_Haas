<?php

namespace App\Tests\Api\Animal;

use App\Factory\AnimalFactory;
use App\Factory\EnclosureFactory;
use App\Factory\SpeciesFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class AnimalPatchCest
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

    public function patchAnimal(ApiTester $I): void
    {
        $specie = SpeciesFactory::createOne(['name' => 'UneChenillllleeee'])->object();
        $enclosure = EnclosureFactory::createOne(['name' => 'LaCage'])->object();

        $animal = AnimalFactory::createOne([
            'name' => 'Coin',
            'description' => 'Coin',
            'enclosure' => $enclosure,
            'species' => $specie,
        ])->object();
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        $I->amLoggedInAs($user);
        $I->sendPatch('/api/animals/1', [
            'name' => 'CoinCoinLeCanard',
            'description' => 'LeCanardFaitCoin',
        ]);

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();

        $I->seeResponseMatchesJsonType($this->expectedProperties());

        $I->seeResponseContainsJson([
            'id' => $animal->getId(),
            'name' => 'CoinCoinLeCanard',
            'description' => 'LeCanardFaitCoin',
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
