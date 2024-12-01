<?php

namespace App\DataFixtures;

use App\Factory\AnimalCategoryFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AnimalCategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $file = file_get_contents(__DIR__.'/data/AnimalCategory.json');
        $file_j = json_decode($file, true);
        AnimalCategoryFactory::createSequence($file_j);
    }
}
