<?php

namespace App\Tests\Api\Rating;

use App\Factory\BookmarkFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class RatingPostDataValidationCest
{
    public function RatingPostDataValidationCest(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        BookmarkFactory::createOne();
        $I->amLoggedInAs($user);
        $dataPost = [
            'bookmark' => '/api/bookmarks/1',
            'user' => '/api/users/1',
            'value' => 5,
        ];
        $I->sendPost('/api/ratings', $dataPost);
        $I->seeResponseCodeIs(201);
        $I->sendGet('/api/ratings/1');
        $I->seeResponseCodeIsSuccessful();
        $I->sendPost('/api/ratings', $dataPost);
        $I->seeResponseCodeIs(422);
    }

    public function valueValidation(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        BookmarkFactory::createOne();
        $I->amLoggedInAs($user);
        $dataPost = [
            'bookmark' => '/api/bookmarks/1',
            'user' => '/api/users/1',
            'value' => -2,
        ];
        $I->sendPost('/api/ratings', $dataPost);
        $I->seeResponseCodeIs(422);

        $dataPost = [
            'bookmark' => '/api/bookmarks/1',
            'user' => '/api/users/1',
            'value' => -15,
        ];
        $I->sendPost('/api/ratings', $dataPost);
        $I->seeResponseCodeIs(422);

        $dataPost = [
            'bookmark' => '/api/bookmarks/1',
            'user' => '/api/users/1',
            'value' => 10,
        ];
        $I->sendPost('/api/ratings', $dataPost);
        $I->seeResponseCodeIs(201);
    }
}
