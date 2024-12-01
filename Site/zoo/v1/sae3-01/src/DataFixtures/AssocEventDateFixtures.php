<?php

namespace App\DataFixtures;

use App\Factory\AssocEventDateFactory;
use App\Factory\EventDateFactory;
use App\Factory\EventFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AssocEventDateFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $events = EventFactory::all();
        $dates = EventDateFactory::all();
        for ($i = 0; $i < 19; ++$i) {
            AssocEventDateFactory::createOne(['eventId ' => $events[$i], 'eventDatesId' => $dates[$i]]);
        }
    }

    public function getDependencies(): array
    {
        return [
            EventDateFixtures::class,
            EventFixtures::class,
        ];
    }
}
