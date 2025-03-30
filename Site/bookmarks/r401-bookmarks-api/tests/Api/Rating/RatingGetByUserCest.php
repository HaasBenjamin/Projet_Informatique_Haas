<?php

namespace App\Tests\Api\Rating;

use App\Factory\BookmarkFactory;
use App\Factory\RatingFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class RatingGetByUserCest
{
    public function AnonymousUserCantGetRatingCollection(ApiTester $I): void
    {
        RatingFactory::createOne();
        $I->sendGet('/api/users/1/ratings');
        $I->seeResponseCodeIs(401);
    }

    public function AnonymousUserCanGetRatingCollection(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        BookmarkFactory::createOne();
        BookmarkFactory::createOne();
        $user2 = UserFactory::createOne()->object();
        $I->amLoggedInAs($user2);
        $dataPost = [
            'bookmark' => '/api/bookmarks/1',
            'user' => '/api/users/2',
            'value' => 5,
        ];

        $dataPost2 = [
            'bookmark' => '/api/bookmarks/2',
            'user' => '/api/users/2',
            'value' => 2,
        ];

        $I->sendPost('/api/ratings', $dataPost);
        $I->sendPost('/api/ratings', $dataPost2);
        $I->logout();
        $I->amLoggedInAs($user);
        $ratings = $I->sendGet('/api/users/2/ratings');
        $I->seeResponseCodeIsSuccessful();
        $I->assertEquals(count(explode('},{', $ratings)), 2);
    }
}
