<?php

namespace Tests\Movies\Collection;

use Entity\ActorMovies;
use Entity\Collection\ActorMoviesCollection;
use Tests\MoviesTester;

class ActorMoviesCollectionCest
{
    public function findAll(MoviesTester $I): void
    {
        $expectedActors = [
            ['id'=>1256603 , 'avatarId'=>3675,'birthday'=>'1991-06-26','deathday'=>null,'name'=>'Natsuki Hanae','biography'=>'','placeOfBirth'=>'Kanagawa Prefecture, Japan'],
            ['id'=>1563442 , 'avatarId'=>3676,'birthday'=>'1994-10-16','deathday'=>null,'name'=>'Akari Kito','biography'=>'','placeOfBirth'=>'Aichi Prefecture, Japan']
        ];

        $actors = ActorMoviesCollection::findAll(895006);
        $I->assertCount(count($expectedActors), $actors);
        $I->assertContainsOnlyInstancesOf(ActorMovies::class, $actors);
        foreach ($actors as $index => $actor) {
            $expectedActor = $expectedActors[$index];
            $I->assertEquals($expectedActor['id'], $actor->getId());
            $I->assertEquals($expectedActor['name'], $actor->getName());
        }
    }
}
