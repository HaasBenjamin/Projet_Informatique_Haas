<?php

namespace App\DataFixtures;

use App\Factory\AnimalFactory;
use App\Factory\EnclosureFactory;
use App\Factory\ImageFactory;
use App\Factory\SpeciesFactory; // manque implémentation de SpeciesFactory
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class AnimalFixtures extends Fixture implements DependentFixtureInterface
{
    /*   public function load(ObjectManager $manager): void
       {
           AnimalFactory::createMany(20, function () {
               if (AnimalFactory::faker()->boolean(30)) {
                   $espece = SpeciesFactory::random();
                   $enclos = EnclosureFactory::random();

                   return [
                       'espece' => $espece,
                       'enclos' => $enclos,
                       'parent1' => AnimalFactory::new([
                           'espece' => $espece,
                           'enclos' => $enclos,
                       ]),
                       'parent2' => AnimalFactory::new([
                           'espece' => $espece,
                           'enclos' => $enclos,
                       ]),
                   ];
               }

               return [];
           });
       }
*/
    public function load(ObjectManager $manager): void
    {
        $file = file_get_contents(__DIR__.'/data/Animals.json');
        $file_j = json_decode($file, true);
        $species = SpeciesFactory::all();
        $enclosures = EnclosureFactory::all();
        for ($i = 0; $i < count($file_j); ++$i) {
            $file_j[$i]['species'] = $species[$i];
            $file_j[$i]['enclosure'] = $enclosures[$i];
            $file_j[$i]['image'] = ImageFactory::createOne();
        }
        AnimalFactory::createSequence($file_j);
    }

    public function getDependencies(): array
    {
        return [
            SpeciesFixtures::class,
            EnclosureFixtures::class,
        ];
    }
}
