<?php

declare(strict_types=1);

namespace Api\Event;

use App\Entity\Event;
use App\Factory\EventFactory;
use App\Tests\Support\ApiTester;

class EventGetCollectionCest
{
    public function getEventsCollection(ApiTester $I)
    {
        EventFactory::createMany(9);
        $I->sendGet('/api/events');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsACollection(Event::class, '/api/events', [
            'hydra:member' => 'array',
            'hydra:totalItems' => 'integer',
        ]);
        $I->seeResponseContainsJson([
            'hydra:totalItems' => 9,
        ]);

    }
}
