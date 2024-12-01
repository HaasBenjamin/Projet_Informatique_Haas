<?php

namespace Tests\Movies\Collection;

use Entity\Collection\MovieCollection;
use Entity\Movie;
use Tests\MoviesTester;

class MovieCollectionCest
{
    public function findAll(MoviesTester $I): void
    {
        $expectedMovies = [
            ['id' => 503314, 'title' => 'Dragon Ball Super - Broly', 'tagline'=> 'Goku et Vegeta font face à un nouvel ennemi, le Super Saïyen Légendaire Broly !','runtime' => 100, 'releaseDate' => '2018-12-14' , 'overview' => "Quelque temps après le Tournoi du Pouvoir, la Terre est paisible. Son Goku et ses amis ont repris leur vie. Cependant, avec son expérience du Tournoi, Son Goku passe son temps à s'entraîner pour continuer à s'améliorer car ce dernier est conscient qu'il reste encore beaucoup d'individus plus forts à découvrir au sein des autres univers. Lorsqu'un jour, le vaisseau de Freezer refait surface sur la Terre. Celui-ci est accompagné d'un Saiyan, nommé Broly, avec son père, Paragus. La surprise de Son Goku et Vegeta est immense puisque les Saiyans sont censés avoir été complètement anéantis lors de la destruction de la planète Vegeta. Ils n'ont donc pas d'autre choix que de s'affronter, mais ce nouvel ennemi s'adapte très vite aux adversaires qu'il affronte…" ,'originalTitle'=>'ドラゴンボール超スーパー ブロリー', 'originalLanguage'=>'ja'  , 'posterId' =>7628 ],
            ['id' => 630, 'title' => "Le Magicien d'Oz", 'tagline'=> 'Une éblouissante fantaisie en couleurs !','runtime' => 101, 'releaseDate' => '1939-08-15' , 'overview' => "Dorothy Gale, une jeune orpheline, est élevée dans une ferme du Kansas tenue par sa tante et son oncle. Son chien Toto étant persécuté par la méchante Almira Gulch, Dorothy demande aux trois ouvriers de la ferme de le protéger. Cependant personne ne semble prendre au sérieux les craintes de la jeune fille. Almira Gulch finit par s'emparer de Toto avec l'intention de le tuer. Mais le chien s'échappe et retourne près de Dorothy qui décide alors de s'enfuir. Arrivée à la ferme, une tornade se forme avant que Dorothy ne puisse se réfugier dans la cave..." ,'originalTitle'=>'The Wizard of Oz', 'originalLanguage'=>'en'  , 'posterId' =>16044 ],
            ['id' => 109, 'title' => 'Trois couleurs : Blanc', 'tagline'=> '','runtime' => 100, 'releaseDate' => '1994-01-26' , 'overview' => "Karol a tout perdu après son divorce avec Dominique, il ne peut même pas retourner en Pologne et refuse de devenir meurtrier pour de l'argent. Après avoir enfin réussi à retourner dans son pays, il se lance dans diverses entreprises et tombe dans le piège de sa vengeance sur Dominique." ,'originalTitle'=>'Trois couleurs : Blanc', 'originalLanguage'=>'fr'  , 'posterId' =>7373 ],
            ['id' => 108, 'title' => 'Trois couleurs : Bleu', 'tagline'=> '','runtime' => 100, 'releaseDate' => '1993-09-08' , 'overview' => "Après la mort de son mari, compositeur réputé, et de leur fille dans un accident de voiture, Julie commence une nouvelle vie, coupant tout lien avec son passé. Ex-assistant du couple, Olivier, amoureux d'elle, tente de l'inciter à terminer le Concerto pour l'Europe." ,'originalTitle'=>'Trois couleurs : Bleu', 'originalLanguage'=>'fr'  , 'posterId' =>7371 ],
            ['id' => 110, 'title' => 'Trois couleurs : Rouge', 'tagline'=> '','runtime' => 100, 'releaseDate' => '1994-05-27' , 'overview' => "Valentine, étudiante à Genève et mannequin à ses heures, passe son temps à attendre les appels téléphoniques de son petit ami, Michel, qui vit en Angleterre. Auguste, son voisin, épris de la douce Karin, travaille d'arrache-pied pour devenir avocat. Sans le savoir, tout ce petit monde a été placé sur écoute par un juge à la retraite, acariâtre et cynique, qui occupe ainsi sa misanthropie et ses vieux jours. Parce qu'au volant de sa voiture, elle a renversé la chienne du juge, Valentine fait la connaissance du vieux grigou et découvre ses basses manies. Dégoûtée autant que fascinée, elle se met à lui rendre de fréquentes visites..." ,'originalTitle'=>'Trois couleurs : Rouge', 'originalLanguage'=>'fr'  , 'posterId' =>7369 ],
            ['id' => 895006, 'title' => '鬼滅の刃 鼓屋敷編', 'tagline'=> '','runtime' => 87, 'releaseDate' => '2021-09-18' , 'overview' => '' ,'originalTitle'=>'鬼滅の刃 鼓屋敷編', 'originalLanguage'=>'ja'  , 'posterId' =>1423 ]
        ];

        $movies = MovieCollection::findAll();
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

    public function getMovieByactorId(MoviesTester $I): void
    {
        $expectedMovies = [
            ['id' => 630, 'title' => "Le Magicien d'Oz", 'tagline'=> 'Une éblouissante fantaisie en couleurs !','runtime' => 101, 'releaseDate' => '1939-08-15' , 'overview' => "Dorothy Gale, une jeune orpheline, est élevée dans une ferme du Kansas tenue par sa tante et son oncle. Son chien Toto étant persécuté par la méchante Almira Gulch, Dorothy demande aux trois ouvriers de la ferme de le protéger. Cependant personne ne semble prendre au sérieux les craintes de la jeune fille. Almira Gulch finit par s'emparer de Toto avec l'intention de le tuer. Mais le chien s'échappe et retourne près de Dorothy qui décide alors de s'enfuir. Arrivée à la ferme, une tornade se forme avant que Dorothy ne puisse se réfugier dans la cave..." ,'originalTitle'=>'The Wizard of Oz', 'originalLanguage'=>'en'  , 'posterId' =>16044 ]
            ];

        $movies = MovieCollection::getMovieByactorId(5460);
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
