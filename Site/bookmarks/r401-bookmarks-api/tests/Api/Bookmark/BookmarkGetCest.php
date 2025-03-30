<?php

namespace App\Tests\Api\Bookmark;

use App\Entity\Bookmark;
use App\Factory\BookmarkFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class BookmarkGetCest
{
    protected static function expectedProperties(): array
    {
        return [
            'id' => 'integer',
            'name' => 'string',
            'description' => 'string',
            'creationDate' => 'string:date',
            'isPublic' => 'boolean',
            'url' => 'string:url',
            'ratings' => 'array',
            'rateAverage' => 'integer|float',
        ];
    }

    public function getBookmarkDetail(ApiTester $I): void
    {
        UserFactory::createOne();
        // 1. 'Arrange'
        $data = [
            'name' => 'My bookmark',
            'description' => 'Bookmark description',
            'creationDate' => new \DateTimeImmutable('now'),
            'isPublic' => true,
            'url' => 'https://example.com/mybookmark#fragment',
        ];
        BookmarkFactory::createOne($data);

        // 2. 'Act'
        $I->sendGet('/api/bookmarks/1');

        // 3. 'Assert'
        $I->seeResponseCodeIsSuccessful();
        $I->seeResponseIsJson();
        $I->seeResponseIsAnEntity(Bookmark::class, '/api/bookmarks/1');
        // Transform Date to W3C date string ("Y-m-d\\TH:i:sP")
        $data['creationDate'] = $data['creationDate']->format(\DateTimeInterface::W3C);
        $I->seeResponseIsAnItem(self::expectedProperties(), $data);
    }

    public function AnonymousUserCantAccessPrivateBookmark(ApiTester $I)
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
        $I->sendGet('/api/bookmarks/1');
        $I->seeResponseCodeIs(401);
    }
}
