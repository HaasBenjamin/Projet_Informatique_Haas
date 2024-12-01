<?php

namespace App\Tests\Controller\Contact;

use App\Factory\ContactFactory;
use App\Tests\Support\ControllerTester;

class IndexCest
{
    public function defaultNumberOnPage(ControllerTester $I): void
    {
        ContactFactory::createMany(5);
        $I->amOnPage('/contact');
        $I->seeResponseCodeIsSuccessful();
        $I->seeInTitle('Liste des contacts');
        $I->see('Liste des contacts', 'h1');
        $I->seeNumberOfElements('.contacts li > a.contact', 5);
    }

    public function tryLinkGiveGoodRoute(ControllerTester $I): void
    {
        ContactFactory::createOne(['firstname' => 'Joe', 'lastname' => 'Aaaaaaaaaaaaaaa']);
        ContactFactory::createMany(5);
        $I->amOnPage('/contact');
        $I->click('Aaaaaaaaaaaaaaa, Joe');
        $I->seeResponseCodeIsSuccessful();
        $I->seeCurrentRouteIs('app_contact_show', ['id' => 1]);
    }

    public function isInsertOrdered(ControllerTester $I): void
    {
        ContactFactory::createSequence(
            [
                ['lastname' => 'Reg', 'firstname' => 'Janice'],
                ['lastname' => 'Eichmann', 'firstname' => 'Jacques'],
                ['lastname' => 'Nicolas', 'firstname' => 'Michelle'],
                ['lastname' => 'Smith', 'firstname' => 'Aurore'],
            ]
        );
        $I->amOnPage('/contact');
        $names = $I->grabMultiple('.contacts a.contact');
        $I->assertEquals([
            'Eichmann, Jacques',
            'Nicolas, Michelle',
            'Reg, Janice',
            'Smith, Aurore',
        ], $names);
    }

    public function ParameterSearchReturnContactsWithString(ControllerTester $I): void
    {
        ContactFactory::createSequence(
            [
                ['lastname' => 'Reg', 'firstname' => 'Janice'],
                ['lastname' => 'Eichmann', 'firstname' => 'Jacques'],
                ['lastname' => 'Nicolas', 'firstname' => 'Michelle'],
                ['lastname' => 'Smith', 'firstname' => 'Nicole'],
            ]
        );
        $I->amOnPage('/contact?search=Nicol');
        $I->seeNumberOfElements('.contacts li > a.contact', 2);
    }
}
