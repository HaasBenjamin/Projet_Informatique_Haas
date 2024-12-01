<?php

declare(strict_types=1);

namespace Api\Event;

use App\Entity\Event;
use App\Factory\EnclosureFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class EventCreateCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'description' => 'string',
            'duration' => 'integer',
            'quota' => 'integer',
            'enclosure' => 'array',
            'eventDates' => 'array',
            'registrations' => 'array',
        ];
    }

    public function seeWhenEventIsCreatedDataIsAdded(ApiTester $I): void
    {
        $user = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        EnclosureFactory::createOne(['name' => 'enclosure']);
        $I->amLoggedInAs($user);
        $dataEvent = [
            'name' => 'mufsasa danse le tango',
            'description' => 'mufsasa danse le tango',
            'duration' => 30,
            'quota' => 30,
            'enclosure' => '/api/enclosures/1',
            'eventDates' => [],
        ];

        $I->sendPost('/api/events', $dataEvent);
        $I->seeResponseCodeIs(HttpCode::CREATED);
        $I->sendGet('/api/events/1');
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Event::class, '/api/events/1');
        $dataEvent['enclosure'] = [
            '@id' => '/api/enclosures/1',
            '@type' => 'Enclosure',
            'id' => 1,
            'name' => 'enclosure',
        ];
        $I->seeResponseIsAnItem(self::expectedProperties(), $dataEvent);
    }
}
