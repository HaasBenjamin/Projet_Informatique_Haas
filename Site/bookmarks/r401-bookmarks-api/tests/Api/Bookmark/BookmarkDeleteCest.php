<?php

namespace Api\Bookmark;

use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class BookmarkDeleteCest
{
    public function AnonymousUserCantDeleteBookmark(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        $data = [
            'name' => 'My bookmark',
            'description' => 'Bookmark description',
            'isPublic' => true,
            'url' => 'https://example.com/mybookmark#fragment',
            'owner' => '/api/users/1',
        ];
        $I->amLoggedInAs($user);
        $I->sendPost('/api/bookmarks', $data);
        $I->logout();
        $I->sendDelete('/api/bookmarks/1');
        $I->seeResponseCodeIs(401);
    }

    public function AuthenticatedUserCantDeleteBookmarkOfOtherUser(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        $data = [
            'name' => 'My bookmark',
            'description' => 'Bookmark description',
            'isPublic' => true,
            'url' => 'https://example.com/mybookmark#fragment',
            'owner' => '/api/users/1',
        ];
        $I->amLoggedInAs($user);
        $I->sendPost('/api/bookmarks', $data);
        $I->logout();
        $user = UserFactory::createOne()->object();
        $I->amLoggedInAs($user);
        $I->sendDelete('/api/bookmarks/1');
        $I->seeResponseCodeIs(401);
    }

    public function AuthenticatedUserCanDeleteOwnBookmark(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        $data = [
            'name' => 'My bookmark',
            'description' => 'Bookmark description',
            'isPublic' => true,
            'url' => 'https://example.com/mybookmark#fragment',
            'owner' => '/api/users/1',
        ];
        $I->amLoggedInAs($user);
        $I->sendPost('/api/bookmarks', $data);
        $I->sendDelete('/api/bookmarks/1');
        $I->seeResponseCodeIs(201);
    }
}
