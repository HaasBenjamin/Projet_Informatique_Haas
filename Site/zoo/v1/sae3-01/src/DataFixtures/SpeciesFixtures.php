<?php

namespace App\DataFixtures;

use App\Factory\AnimalFamilyFactory;
use App\Factory\DietFactory;
use App\Factory\SpeciesFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class SpeciesFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        $file = file_get_contents(__DIR__.'/data/SpeciesName.json');
        $file_j = json_decode($file, true);
        $regimes = DietFactory::all(); // 0 = carnivores - 1 = herbivores - 2 = omnivores
        $families = AnimalFamilyFactory::all();
        $diets_att = [$regimes[2], $regimes[0], $regimes[1], $regimes[2], $regimes[1], $regimes[0], $regimes[0], $regimes[0], $regimes[1], $regimes[1], $regimes[1], $regimes[0], $regimes[1],
            $regimes[0], $regimes[1], $regimes[1], $regimes[0], $regimes[0], $regimes[0], $regimes[1], ];
        $families_att = [$families[4], $families[4], $families[7], $families[7], $families[4], $families[0], $families[0], $families[0], $families[11], $families[12], $families[13], $families[14], $families[2],
            $families[15], $families[16], $families[17], $families[1], $families[18], $families[19], $families[20]];
        for ($i = 0; $i < count($file_j); ++$i) {
            $file_j[$i]['diet'] = $diets_att[$i];
            $file_j[$i]['family'] = $families_att[$i];
        }
        SpeciesFactory::createSequence($file_j);
    }

    public function getDependencies(): array
    {
        return [
            AnimalFamilyFixtures::class,
            DietFixtures::class,
        ];
    }
}
