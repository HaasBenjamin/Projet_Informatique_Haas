<?php

namespace App\DataFixtures;

use App\Factory\DietFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DietFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $file = file_get_contents(__DIR__.'/data/Diet.json');
        $file_j = json_decode($file, true);
        DietFactory::createSequence($file_j);
    }
}
