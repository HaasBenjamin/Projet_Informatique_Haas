<?php
namespace Tests\Movies\Collection;
use Entity\Movie;
use Tests\MoviesTester;
use Entity\Collection\GenderMoviesCollection;
use Entity\Gender;


class GenderMoviesCollectionCest
{
    public function findAll(MoviesTester $I): void
    {
        $expectedGenders = [
            ['id'=>28 , 'name'=>'Action'],
            ['id'=>16 , 'name'=>'Animation'],
            ['id'=>12 , 'name'=>'Aventure'],
            ['id'=>35 , 'name'=>'Comédie'],
            ['id'=>18 , 'name'=>'Drame']
            ,['id'=>10751 , 'name'=>'Familial'],
            ['id'=>14 , 'name'=>'Fantastique'],
            ['id'=>9648, 'name'=>'Mystère'],
            ['id'=> 10749 , 'name'=>'Romance'],
            ['id'=>878 , 'name'=>'Science-Fiction']
            ];

        $genders = GenderMoviesCollection::findAll();
        $I->assertCount(count($expectedGenders), $genders);
        $I->assertContainsOnlyInstancesOf(Gender::class, $genders);
        foreach ($genders as $index => $gender) {
            $expectedGender = $expectedGenders[$index];
            $I->assertEquals($expectedGender['id'], $gender->getId());
            $I->assertEquals($expectedGender['name'], $gender->getName());
        }
    }
    public function findAllMoviesByGender(MoviesTester $I): void
    {
        $expectedMovies = [
            ['id' => 503314, 'title' => 'Dragon Ball Super - Broly', 'tagline'=> 'Goku et Vegeta font face à un nouvel ennemi, le Super Saïyen Légendaire Broly !','runtime' => 100, 'releaseDate' => '2018-12-14' , 'overview' => "Quelque temps après le Tournoi du Pouvoir, la Terre est paisible. Son Goku et ses amis ont repris leur vie. Cependant, avec son expérience du Tournoi, Son Goku passe son temps à s'entraîner pour continuer à s'améliorer car ce dernier est conscient qu'il reste encore beaucoup d'individus plus forts à découvrir au sein des autres univers. Lorsqu'un jour, le vaisseau de Freezer refait surface sur la Terre. Celui-ci est accompagné d'un Saiyan, nommé Broly, avec son père, Paragus. La surprise de Son Goku et Vegeta est immense puisque les Saiyans sont censés avoir été complètement anéantis lors de la destruction de la planète Vegeta. Ils n'ont donc pas d'autre choix que de s'affronter, mais ce nouvel ennemi s'adapte très vite aux adversaires qu'il affronte…" ,'originalTitle'=>'ドラゴンボール超スーパー ブロリー', 'originalLanguage'=>'ja'  , 'posterId' =>7628 ]
        ];

        $movies = GenderMoviesCollection::findAllMoviesByGender(878);
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
