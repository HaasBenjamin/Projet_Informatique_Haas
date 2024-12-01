<?php

namespace App\Tests\Controller\Contact;

use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;
use Codeception\Util\HttpCode;

class CreateCest
{
    public function form(ControllerTester $I): void
    {
        $user = UserFactory::createOne([
            'firstname' => 'Jean',
            'lastname' => 'Dupont',
            'roles' => ['ROLE_ADMIN'],
        ]);

        $userObj = $user->object();
        $I->amLoggedInAs($userObj);
        $I->amOnPage('/contact/create');

        $I->seeInTitle("Création d'un nouveau contact");
        $I->see("Création d'un nouveau contact", 'h1');
    }

    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        $I->amOnPage('/contact/create');
        $I->amOnPage('/login');
    }
}
