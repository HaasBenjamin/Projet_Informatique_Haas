<?php

namespace App\Tests\Controller\Contact;

use App\Factory\ContactFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;
use Codeception\Util\HttpCode;

class UpdateCest
{
    public function formShowsContactDataBeforeUpdating(ControllerTester $I): void
    {
        ContactFactory::createOne([
            'firstname' => 'Homer',
            'lastname' => 'Simpson',
        ]);

        $user = UserFactory::createOne([
            'firstname' => 'Jean',
            'lastname' => 'Dupont',
            'roles' => ['ROLE_ADMIN'],
        ]);

        $userObj = $user->object();
        $I->amLoggedInAs($userObj);
        $I->amOnPage('/contact/1/update');

        $I->seeInTitle('Édition de Simpson, Homer');
        $I->see('Édition de Simpson, Homer', 'h1');
    }

    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        $contact = ContactFactory::createOne([
            'firstname' => 'Homer',
            'lastname' => 'Simpson',
        ]);
        $I->amOnPage("/contact/{$contact->getId()}/update");
        $I->amOnPage('/login');
    }

    public function accessIsRestrictedToAdminUsers(ControllerTester $I): void
    {
        $contact = ContactFactory::createOne([
            'firstname' => 'Homer',
            'lastname' => 'Simpson',
        ]);

        $user = UserFactory::createOne([
            'firstname' => 'Jean',
            'lastname' => 'Dupont',
            'roles' => ['ROLE_USER'],
        ]);

        $userObj = $user->object();
        $I->amLoggedInAs($userObj);
        $I->amOnPage("/contact/{$contact->getId()}/update");
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
