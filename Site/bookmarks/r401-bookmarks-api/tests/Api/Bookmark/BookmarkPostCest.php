<?php

namespace Api\Bookmark;

use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class BookmarkPostCest
{
    public function AnonymousUserCantCreateBookmark(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        $data = [
            'name' => 'My bookmark',
            'description' => 'Bookmark description',
            'isPublic' => true,
            'url' => 'https://example.com/mybookmark#fragment',
            'owner' => '/api/users/1',
        ];
        $I->sendPost('/api/bookmarks', $data);
        $I->seeResponseCodeIs(401);
    }

    public function AuthenticatedUserCanCreateBookmark(ApiTester $I): void
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
        $I->seeResponseCodeIs(201);
    }
}
