<?php

declare(strict_types=1);

namespace Api\Event;

use App\Factory\EventFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class EventDeleteCest
{
    public function seeWhenEventIsDeletedDataIsRemoved(ApiTester $I): void
    {
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        $I->amLoggedInAs($user);
        EventFactory::createOne();
        $I->sendDelete('/api/events/1');
        $I->seeResponseCodeIs(HttpCode::NO_CONTENT);
    }
}
