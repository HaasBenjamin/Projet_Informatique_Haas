<?php

namespace Tests\Livrable2;

use Entity\Movie;
use Tests\Livrable2Tester;

class MoviesModifCest
{/*
    public function delete(Livrable2Tester $I)
    {
        $movie1 = Movie::findById(630);
        $movie1->delete();
        $I->cantSeeInDatabase('movie', ['id' => 630]);
        $I->cantSeeInDatabase('movie', ['title' => "Le Magicien d'Oz"]);
        $I->assertNull($movie1->getId());
        $I->assertSame("Le Magicien d'Oz", $movie1->getTitle());
    }

    public function update(Livrable2Tester $I)
    {
        $movie = Movie::findById(109);
        $movie->setTitle('A');
        $movie->save();
        $I->canSeeNumRecords(1, 'movie', [
            'id' => 109,
            'title'=>'A'



        ]);
        $I->assertSame(109, $movie->getId());
        $I->assertSame('A', $movie->getTitle());
    }

*/
    public function insert(Livrable2Tester $I)
    {
        $movie = Movie::create("BB","BBBBB",34,'2000-12-24','TTTTT','fr','fr',null);
        $movie->save();
        $I->canSeeNumRecords(1, 'movie', [
            'id' =>895007,
            'posterId'=>null,
            'originalLanguage'=>'fr',
            'originalTitle'=>'fr',
            'overview'=>'TTTTT',
            'realeaseDate'=>'2000-12-24',
            'runtime'=>34,
            'tagline'=>"BBBBB",
            'title' => "BB",
        ]);
        $I->assertSame($movie->getId(),895007);
        $I->assertSame('BB', $movie->getTitle());
    }


}
