<?php


namespace App\Tests\Api\Rating;

use App\Entity\User;
use App\Factory\BookmarkFactory;
use App\Factory\RatingFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;
use Codeception\Util\HttpCode;

class RatingDeleteCest
{
    public function AnonymousUserCantDeleteRating(ApiTester $I): void
    {
        RatingFactory::createOne();
        $dataPatch = [
            'value' => 2,
        ];
        $I->sendDelete('/api/ratings/1');
        $I->seeResponseCodeIs(401);
    }

    public function authenticatedUserForbiddenToDeleteOtherUserRating(ApiTester $I): void
    {
        // 1. 'Arrange'
        /** @var $user User */
        $user = UserFactory::createOne()->object();
        BookmarkFactory::createOne();
        $user2 = UserFactory::createOne()->object();
        $I->amLoggedInAs($user2);
        $dataPost = [
            'bookmark' => '/api/bookmarks/1',
            'user' => '/api/users/2',
            'value' => 5,
        ];

        $I->sendPost('/api/ratings', $dataPost);
        $I->logout();
        $I->amLoggedInAs($user);
        $I->sendDelete('/api/ratings/1');

        // 3. 'Assert'
        $I->seeResponseCodeIs(HttpCode::FORBIDDEN);
    }

    public function authenticatedUserCanDeleteOwnRating(ApiTester $I): void
    {
        // 1. 'Arrange'
        /** @var $user User */
        $user = UserFactory::createOne()->object();
        BookmarkFactory::createOne();
        $I->amLoggedInAs($user);
        $dataPost = [
            'bookmark' => '/api/bookmarks/1',
            'user' => '/api/users/1',
            'value' => 5,
        ];
        $I->sendPost('/api/ratings', $dataPost);
        $I->sendDelete('/api/ratings/1');

        // 3. 'Assert'
        $I->seeResponseCodeIs(204);
    }
}
