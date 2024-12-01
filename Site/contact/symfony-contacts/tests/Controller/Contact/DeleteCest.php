<?php

namespace App\Tests\Controller\Contact;

use App\Factory\ContactFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ControllerTester;
use Codeception\Util\HttpCode;

class DeleteCest
{
    public function formShowsContactDataBeforeDeleting(ControllerTester $I): void
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
        $I->amOnPage('/contact/1/delete');

        $I->seeInTitle('Suppression de Simpson, Homer');
        $I->see('Suppression de Simpson, Homer', 'h1');
    }

    public function accessIsRestrictedToAuthenticatedUsers(ControllerTester $I): void
    {
        $contact = ContactFactory::createOne([
            'firstname' => 'Homer',
            'lastname' => 'Simpson',
        ]);
        $I->amOnPage("/contact/{$contact->getId()}/delete");
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
        $I->amOnPage("/contact/{$contact->getId()}/delete");
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }
}
