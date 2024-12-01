<?php

namespace App\DataFixtures;

use App\Factory\EnclosureFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class EnclosureFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $file = file_get_contents(__DIR__.'/data/Enclosure.json');
        $file_j = json_decode($file, true);
        EnclosureFactory::createSequence($file_j);
    }
}