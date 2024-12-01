<?php

declare(strict_types=1);

namespace Api\Event;

use App\Entity\Event;
use App\Factory\EventFactory;
use App\Tests\Support\ApiTester;

class EventGetCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'description' => 'string',
            'duration' => 'integer',
            'quota' => 'integer',
            'enclosure' => 'string',
            'eventDates' => 'array',
            'registrations' => 'array',
        ];
    }

    public function getDetailsEvent(ApiTester $I)
    {
        EventFactory::createOne();
        $I->sendGet('/api/events/1');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Event::class, '/api/events/1');
    }
}
