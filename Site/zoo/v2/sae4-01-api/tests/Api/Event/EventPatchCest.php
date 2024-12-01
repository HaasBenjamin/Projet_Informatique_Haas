<?php

declare(strict_types=1);

namespace Api\Event;

use App\Entity\Event;
use App\Factory\EventFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class EventPatchCest
{
    public function seeWhenEventIsPatchedDataIsUpdated(ApiTester $I): void
    {
        $dataEvent = [
            'name' => 'mufsasa danse le tango',
        ];
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        $I->amLoggedInAs($user);
        EventFactory::createOne();
        $I->sendPatch('/api/events/1', $dataEvent);
        $I->seeResponseCodeIsSuccessful();
        $I->sendGet('/api/events/1');
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Event::class, '/api/events/1');
        $I->seeResponseContainsJson([
            'name' => 'mufsasa danse le tango',
        ]);
    }
}
