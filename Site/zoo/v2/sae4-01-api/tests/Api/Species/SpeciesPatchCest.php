<?php

namespace App\Tests\Api\Species;

use App\Factory\SpeciesFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class SpeciesPatchCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'description' => 'string',
            'family' => 'string',
            'animals' => 'array',
            'diet' => 'string',
            // 'image' => 'string',
        ];
    }

    public function PatchSpecies(ApiTester $I): void
    {
        SpeciesFactory::createOne(['description' => 'desc']);
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        $I->amLoggedInAs($user);
        $I->sendPatch('/api/species/1', ['description' => 'desc species']);

        $I->seeResponseCodeIsSuccessful();

        $I->sendGet('/api/species/1');

        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnItem(self::expectedProperties(), ['description' => 'desc species']);
    }
}
