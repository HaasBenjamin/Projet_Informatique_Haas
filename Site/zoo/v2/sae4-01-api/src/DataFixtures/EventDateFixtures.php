<?php

namespace App\DataFixtures;

use App\Factory\EventDateFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EventDateFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        EventDateFactory::createMany(20);
    }

    public function getDependencies()
    {
        return [
            EventFixtures::class,
        ];
    }
}