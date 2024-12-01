<?php

namespace App\DataFixtures;

use App\Factory\AnimalCategoryFactory;
use App\Factory\AnimalFamilyFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnimalFamilyFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $file = file_get_contents(__DIR__.'/data/Family.json');
        $file_j = json_decode($file, true);
        $cat = AnimalCategoryFactory::all();
        $catFamilly = [$cat[0], $cat[0], $cat[0], $cat[0], $cat[0], $cat[0], $cat[0], $cat[0], $cat[1], $cat[2], $cat[3], $cat[0], $cat[0], $cat[0],
            $cat[1], $cat[1], $cat[0], $cat[0], $cat[1], $cat[2], $cat[2]];
        for ($i = 0; $i < count($file_j); ++$i) {
            $file_j[$i]['category'] = $catFamilly[$i];
        }
        AnimalFamilyFactory::createSequence($file_j);
    }

    public function getDependencies(): array
    {
        return [
            AnimalCategoryFixtures::class,
        ];
    }
}
