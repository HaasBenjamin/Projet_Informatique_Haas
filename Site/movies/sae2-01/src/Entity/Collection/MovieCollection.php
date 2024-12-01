<?php

declare(strict_types=1);

namespace Entity\Collection;

use Database\MyPdo;
use Entity\Movie;
use PDO;

class MovieCollection
{
    /** Méthode qui retourne un tableau contenant tous les movies triés par ordre aplhabétique
     * @return Movie[]
     */
    public static function findAll(): array
    {
        $requete=MyPdo::getInstance()->prepare(
            <<<SQL
                SELECT *
                FROM movie
                ORDER BY title;
SQL
        );
        $requete->execute();
        return $requete->fetchAll(PDO::FETCH_CLASS, Movie::class);


    }

    /**Methode qui permet de renvoyer l'ensemble des films d'un acteur dont son identifier  est donné en paramètre
     * @param int $PeopleId
     * @return Movie[]
     */
    public static function getMovieByactorId(int $PeopleId): array
    {
        $request=MyPdo::getInstance()->prepare(
            <<<SQL
                SELECT m.id,title,tagline,runtime,releaseDate,overview,originalTitle,originalLanguage,posterId
                FROM cast c, movie m
                WHERE c.peopleId=:PeopleId
                AND c.movieID = m.id
                order BY 2;
SQL
        );
        $request->execute([":PeopleId"=>$PeopleId]);
        return $request->fetchAll(PDO::FETCH_CLASS, Movie::class);


    }
}
