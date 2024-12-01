<?php

namespace App\DataFixtures;

use App\Factory\ImageFactory;
use App\DataFixtures\AnimalFixtures;
use App\DataFixtures\AnimalFamilyFixtures;
use App\DataFixtures\SpeciesFixtures;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class ImageFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        // ImageFactory::createMany(2); Permet de créer deux images reliées à rien (pas très utile pour le moment...)
    }

    public function getDependencies(): array
    {
        return [
            SpeciesFixtures::class,
            AnimalFamilyFixtures::class,
        ];
    }
}
