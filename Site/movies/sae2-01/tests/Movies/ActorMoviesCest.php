<?php

namespace Tests\Movies;

use Database\MyPdo;
use Entity\ActorMovies;
use PDO;
use Tests\MoviesTester;

class ActorMoviesCest
{
    public function findById(MoviesTester $I): void
    {
        $expectedActors = [
            ['id' => 1140, 'avatarId'=>7902,'birthday'=>null,'deathday'=>null,'name'=>'Charlotte Véry','biography'=>'','placeOfBirth'=>'']
        ];

        $actors = [ActorMovies::findById(1140)];
        $I->assertCount(count($expectedActors), $actors);
        $I->assertContainsOnlyInstancesOf(ActorMovies::class, $actors);
        foreach ($actors as $index => $actor) {
            $expectedActor = $expectedActors[$index];
            $I->assertEquals($expectedActor['id'], $actor->getId());
            $I->assertEquals($expectedActor['avatarId'], $actor->getAvatarId());
            $I->assertEquals($expectedActor['birthday'], $actor->getBirthday());
            $I->assertEquals($expectedActor['deathday'], $actor->getDeathday());
            $I->assertEquals($expectedActor['name'], $actor->getName());
            $I->assertEquals($expectedActor['biography'], $actor->getBiography());
            $I->assertEquals($expectedActor['placeOfBirth'], $actor->getPlaceOfBirth());
        }
    }

    public function getRole(MoviesTester $I): void
    {
        $expectedRoles = [
            'Julie Vignon'
        ];
        $request=MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT  *
            FROM people
            WHERE id = :idActor
SQL
        );
        $request->setFetchMode(PDO::FETCH_CLASS, ActorMovies::class);
        $request->execute([":idActor" =>1137 ]);
        $actors=$request->fetch();
        $roles = [$actors->getRole(108)];
        $I->assertCount(count($expectedRoles), $roles);
        $I->assertEquals($expectedRoles, $roles);

    }

}
