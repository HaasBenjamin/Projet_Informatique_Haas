<?php

namespace App\Tests\Api\Rating;

use App\Factory\BookmarkFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class RatingCreateCest
{
    public function AnonymousUserCantCreateRating(ApiTester $I): void
    {
        UserFactory::createOne()->object();
        BookmarkFactory::createOne();
        $dataPost = [
            'bookmark' => '/api/bookmarks/1',
            'user' => '/api/users/1',
            'value' => 5,
        ];
        $I->sendPost('/api/ratings', $dataPost);
        $I->seeResponseCodeIs(401);
    }

    public function AuthenticatedUserCanCreateRating(ApiTester $I): void
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
    }

    public function AuthenticatedUserCantCreateRatingForOtherUser(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        UserFactory::createOne();
        BookmarkFactory::createOne();
        $I->amLoggedInAs($user);

        $dataPost = [
            'bookmark' => '/api/bookmarks/1',
            'user' => '/api/users/2',
            'value' => 5,
        ];
        $I->sendPost('/api/ratings', $dataPost);

        $I->seeResponseCodeIs(422);
    }

    public function AuthenticatedUserCanCreateRatingWithoutUser(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        $I->amLoggedInAs($user);
        BookmarkFactory::createOne();
        $dataPost = [
            'bookmark' => '/api/bookmarks/1',
            'value' => 5,
        ];
        $I->sendPost('/api/ratings', $dataPost);
        $I->seeResponseCodeIsSuccessful();
    }
}
