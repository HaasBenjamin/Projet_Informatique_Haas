<?php

namespace Controller\Animal;

use App\Entity\Animal;
use App\Factory\AnimalFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;

class DeleteCest
{
    public function accessIsRestrictedForNoAdmin(ControllerTester $I): void
    {
        $I->amOnPage('/animal/create');
        $I->amOnRoute('app_login');
    }

    public function formDeleteAnimal(ControllerTester $I): void
    {
        $adminUser = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        $I->amLoggedInAs($adminUser);

        AnimalFactory::createOne([
            'name' => 'Pierre',
            'description' => 'Pierre est un cailloux',
        ]);

        $I->amOnPage('/animal/1/delete');

        $I->seeInTitle('Suppression de Pierre');
        $I->see('Suppression de Pierre', 'h1');
    }

    public function formDeleteAnimalDenied(ControllerTester $I): void
    {
        $adminUser = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        $I->amLoggedInAs($adminUser);

        AnimalFactory::createOne([
            'name' => 'Pierre',
            'description' => 'Pierre est un cailloux',
        ]);

        $I->amOnPage('/animal/1/delete');
        $I->click('Annuler');

        $I->seeCurrentUrlEquals('/animal/1');
    }

    public function formDeleteAnimalAccepted(ControllerTester $I): void
    {
        $adminUser = UserFactory::createOne(['roles' => ['ROLE_ADMIN']])->object();
        $I->amLoggedInAs($adminUser);

        AnimalFactory::createOne([
            'name' => 'Pierre',
            'description' => 'Pierre est un cailloux',
        ]);

        $I->amOnPage('/animal/1/delete');

        $I->click('Supprimer');

        $I->seeInCurrentUrl('/animals');
        $I->dontSeeInRepository(Animal::class, [
            'name' => 'Pierre',
            'description' => 'Pierre est un cailloux',
        ]);
    }
}
