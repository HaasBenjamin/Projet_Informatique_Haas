<?php

namespace Tests\Movies;

use Entity\Movie;
use Tests\MoviesTester;

class MovieCest
{
    public function findById(MoviesTester $I): void
    {
        $expectedMovies = [
            ['id' => 109, 'title' => 'Trois couleurs : Blanc', 'tagline'=> '','runtime' => 100, 'releaseDate' => '1994-01-26' , 'overview' => "Karol a tout perdu après son divorce avec Dominique, il ne peut même pas retourner en Pologne et refuse de devenir meurtrier pour de l'argent. Après avoir enfin réussi à retourner dans son pays, il se lance dans diverses entreprises et tombe dans le piège de sa vengeance sur Dominique." ,'originalTitle'=>'Trois couleurs : Blanc', 'originalLanguage'=>'fr'  , 'posterId' =>7373 ]
        ];

        $movies = [Movie::findById(109)];
        $I->assertCount(count($expectedMovies), $movies);
        $I->assertContainsOnlyInstancesOf(Movie::class, $movies);
        foreach ($movies as $index => $movie) {
            $expectedMovie = $expectedMovies[$index];
            $I->assertEquals($expectedMovie['id'], $movie->getId());
            $I->assertEquals($expectedMovie['title'], $movie->getTitle());
            $I->assertEquals($expectedMovie['tagline'], $movie->getTagline());
            $I->assertEquals($expectedMovie['runtime'], $movie->getRuntime());
            $I->assertEquals($expectedMovie['releaseDate'], $movie->getReleaseDate());
            $I->assertEquals($expectedMovie['overview'], $movie->getOverview());
            $I->assertEquals($expectedMovie['originalTitle'], $movie->getOriginalTitle());
            $I->assertEquals($expectedMovie['originalLanguage'], $movie->getOriginalLanguage());
            $I->assertEquals($expectedMovie['posterId'], $movie->getPosterId());
        }
    }

}
