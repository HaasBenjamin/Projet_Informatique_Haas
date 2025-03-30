<?php

namespace App\Tests\Api\Rating;

use App\Factory\BookmarkFactory;
use App\Factory\RatingFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class RatingGetCest
{
    public function AnonymousUserCanGetCollection(ApiTester $I): void
    {
        $I->sendGet('/api/ratings');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
    }

    public function AnonymousUserCanGetRating(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        $bookmark = BookmarkFactory::createOne()->object();
        $dataPost = [
            'bookmark' => $bookmark,
            'user' => $user,
            'value' => 5,
        ];
        RatingFactory::createOne($dataPost);
        $I->sendGet('/api/ratings/1');
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
    }
}
