<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Gender;
use Entity\Movie;
use PDO;

class GenderMoviesCollection
{
    /**
     * Méthode qui renvoie tous les genres différents
     * @return array
     */
    public static function findAll(): array
    {
        $request = MyPDO::getInstance()->prepare(
            <<<'SQL'
             SELECT  *
             FROM genre
             ORDER BY name
SQL
        );
        $request->execute();
        return $request->fetchAll(PDO::FETCH_CLASS, Gender::class);

    }

    /**
     * Méthode permettant de récupérer tous les films appartenant à un même genre
     * @param int $genderId
     * @return array
     */
    public static function findAllMoviesByGender(int $genderId): array
    {
        $request = MyPDO::getInstance()->prepare(
            <<<'SQL'
             SELECT *
             FROM movie 
             WHERE id IN (SELECT movieId
                            FROM movie_genre
                            WHERE genreId= :genreId)
            ORDER BY title;
            
             
SQL
        );
        $request->bindValue(':genreId', $genderId);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_CLASS, Movie::class);

    }


}
