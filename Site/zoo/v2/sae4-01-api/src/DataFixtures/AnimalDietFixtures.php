<?php

namespace App\DataFixtures;

use App\Factory\AnimalDietFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AnimalDietFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $file = file_get_contents(__DIR__.'/data/Diet.json');
        $file_j = json_decode($file, true);
        AnimalDietFactory::createSequence($file_j);
    }
}