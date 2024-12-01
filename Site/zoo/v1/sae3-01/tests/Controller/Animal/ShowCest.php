<?php

namespace Controller\Animal;

use App\Entity\Animal;
use App\Factory\AnimalCategoryFactory;
use App\Factory\AnimalFactory;
use App\Factory\AnimalFamilyFactory;
use App\Factory\DietFactory;
use App\Factory\EnclosureFactory;
use App\Factory\SpeciesFactory;
use App\Tests\Support\ControllerTester;
use Zenstruck\Foundry\Proxy;

class ShowCest
{
    private function generateAnimalDB(): Proxy|Animal
    {
        DietFactory::createOne();
        AnimalCategoryFactory::createOne();
        AnimalFamilyFactory::createOne();
        EnclosureFactory::createOne();
        SpeciesFactory::createOne();

        return AnimalFactory::createOne();
    }

    public function RedirectIfAnimalNotFound(ControllerTester $I): void
    {
        $I->amOnPage('/animal/1');

        $I->seeCurrentUrlEquals('/animals');
    }

    public function ShowPageIsOk(ControllerTester $I): void
    {
        AnimalFactory::createOne([
            'name' => 'Pierre',
            'description' => 'Pierre est un cailloux',
            'enclosure' => EnclosureFactory::createOne(['name' => 'Le cirque']),
            'species' => SpeciesFactory::createOne(['name' => 'stone']),
        ]);

        $I->amOnPage('/animal/1');

        $I->seeInTitle('Pierre');
        $I->see('Pierre', 'h1');
        $I->see('Pierre', 'dt:contains("Nom :") + dd');
        $I->see('Pierre est un cailloux', 'dt:contains("Description :") + dd');
        $I->see('stone', 'dt:contains("Espèce :") + dd');
        $I->see('Le cirque', 'dt:contains("Enclos :") + dd');
    }
}
