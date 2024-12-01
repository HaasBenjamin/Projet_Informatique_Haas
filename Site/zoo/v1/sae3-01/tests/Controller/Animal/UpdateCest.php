<?php

namespace Controller\Animal;

use App\Entity\Animal;
use App\Factory\AnimalFactory;
use App\Factory\EnclosureFactory;
use App\Factory\SpeciesFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class UpdateCest
{
    public function accessIsRestrictedForNoAdmin(ControllerTester $I): void
    {
        $I->amOnPage('/animal/create');
        $I->amOnRoute('app_login');
    }

    public function formUpdateAnimal(ControllerTester $I): void
    {
        $adminUser = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        $I->amLoggedInAs($adminUser);

        AnimalFactory::createOne([
            'name' => 'Pierre',
            'description' => 'Pierre est un cailloux',
            'enclosure' => EnclosureFactory::createOne(['name' => 'Le cirque']),
            'species' => SpeciesFactory::createOne(['name' => 'stone']),
        ]);

        $I->amOnPage('/animal/1/update');

        $I->seeInTitle('Édition de Pierre');
        $I->see('Édition de Pierre', 'h1');
        $I->seeInField('Nom de l\'animal', 'Pierre');
        $I->seeInField('Description de l\'animal', 'Pierre est un cailloux');
        $I->seeOptionIsSelected('Espèce de l\'animal', 'stone');
        $I->seeOptionIsSelected('Enclos de l\'animal', 'Le cirque');
    }

    public function FormUpdateAnimalSend(ControllerTester $I): void
    {
        $adminUser = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        $I->amLoggedInAs($adminUser);

        AnimalFactory::createOne([
            'name' => 'Pierre',
            'description' => 'Pierre est un cailloux',
            'enclosure' => EnclosureFactory::createOne(['name' => 'Le cirque']),
            'species' => SpeciesFactory::createOne(['name' => 'stone']),
        ]);

        $I->amOnPage('/animal/1/update');

        $I->fillField('Nom de l\'animal', 'Antoine');
        $I->fillField('Description de l\'animal', 'Antoine le go muscu');
        $I->click('Modifier');

        $I->seeCurrentUrlEquals('/animal/1');
        $I->SeeInRepository(Animal::class, [
            'name' => 'Antoine',
            'description' => 'Antoine le go muscu',
            'species' => [
                'name' => 'stone',
            ],
            'enclosure' => [
                'name' => 'Le cirque',
            ],
        ]);
    }
}
