<?php

namespace App\Tests\Api\Bookmark;

use App\Factory\BookmarkFactory;
use App\Factory\UserFactory;
use App\Tests\Support\ApiTester;

class BookmarkRateAverageCest
{
    public function SeeRateAvgIs0AtCreating(ApiTester $I): void
    {
        UserFactory::createOne();
        $data = [
            'name' => 'My bookmark',
            'description' => 'Bookmark description',
            'creationDate' => new \DateTimeImmutable('now'),
            'isPublic' => true,
            'url' => 'https://example.com/mybookmark#fragment',
        ];
        $bookmark = BookmarkFactory::createOne($data)->getRateAverage();
        $I->assertEquals($bookmark, 0);
    }

    public function SeeAddRatingChangeRateAverage(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        $data = [
            'name' => 'My bookmark',
            'description' => 'Bookmark description',
            'creationDate' => new \DateTimeImmutable('now'),
            'isPublic' => true,
            'url' => 'https://example.com/mybookmark#fragment',

        ];
        $bookmark = BookmarkFactory::createOne($data);

        $I->amLoggedInAs($user);
        $dataPost = [
            'bookmark' => '/api/bookmarks/1',
            'user' => '/api/users/1',
            'value' => 5,
        ];
        $I->sendPost('/api/ratings', $dataPost);
        $I->sendGet('/api/bookmarks/1');
        $I->assertEquals($bookmark->getRateAverage(), 5);
        $I->logout();
        $user = UserFactory::createOne()->object();
        $I->amLoggedInAs($user);
        $dataPost = [
            'bookmark' => '/api/bookmarks/1',
            'user' => '/api/users/2',
            'value' => 7,
        ];
        $I->sendPost('/api/ratings', $dataPost);
        $I->sendGet('/api/bookmarks/1');
        $I->assertEquals($bookmark->getRateAverage(), 6);
    }

    public function SeeRateavgIsChangedAfterModify(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        $bookmark = BookmarkFactory::createOne();
        $I->amLoggedInAs($user);
        $dataPost = [
            'bookmark' => '/api/bookmarks/1',
            'user' => '/api/users/1',
            'value' => 5,
        ];
        $I->sendPost('/api/ratings', $dataPost);
        $dataPatch = [
            'value' => 2,
        ];
        $I->sendPatch('/api/ratings/1', $dataPatch);
        $I->sendGet('/api/bookmarks/1');
        $I->assertEquals($bookmark->getRateAverage(), 2);
    }

    public function SeeRateavgIsChangedAfterDeleteOne(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        $bookmark = BookmarkFactory::createOne();
        $I->amLoggedInAs($user);
        $dataPost = [
            'bookmark' => '/api/bookmarks/1',
            'user' => '/api/users/1',
            'value' => 5,
        ];
        $I->sendPost('/api/ratings', $dataPost);
        $user = UserFactory::createOne()->object();
        $I->amLoggedInAs($user);
        $dataPost = [
            'bookmark' => '/api/bookmarks/1',
            'user' => '/api/users/2',
            'value' => 7,
        ];
        $I->sendPost('/api/ratings', $dataPost);
        $I->sendGet('/api/bookmarks/1');
        $I->assertEquals($bookmark->getRateAverage(), 6);
        $I->sendDelete('/api/ratings/2');
        $I->sendGet('/api/bookmarks/1');
        $I->assertEquals($bookmark->getRateAverage(), 5);
    }

    public function SeeRateavgIsChangedAfterDeleteAll(ApiTester $I): void
    {
        $user = UserFactory::createOne()->object();
        $bookmark = BookmarkFactory::createOne();
        $I->amLoggedInAs($user);
        $dataPost = [
            'bookmark' => '/api/bookmarks/1',
            'user' => '/api/users/1',
            'value' => 5,
        ];
        $I->sendPost('/api/ratings', $dataPost);
        $I->sendDelete('/api/ratings/1');
        $I->sendGet('/api/bookmarks/1');
        $I->assertEquals($bookmark->getRateAverage(), 0);
    }
}
