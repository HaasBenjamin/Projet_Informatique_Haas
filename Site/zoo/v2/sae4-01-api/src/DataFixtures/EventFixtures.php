<?php

namespace App\DataFixtures;

use App\Factory\AnimalFactory;
use App\Factory\EnclosureFactory;
use App\Factory\EventFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $files = file_get_contents(__DIR__.'/data/Event.json');
        $file_j = json_decode($files, true);
        $enclosures = EnclosureFactory::all();
        $animals = AnimalFactory::all();

        for ($i = 0; $i < count($file_j); ++$i) {
            $file_j[$i]['enclosure'] = $enclosures[$i];
        }
        EventFactory::createSequence($file_j);
    }

    public function getDependencies(): array
    {
        return [
            EnclosureFixtures::class,
            AnimalFixtures::class,
        ];
    }
}
