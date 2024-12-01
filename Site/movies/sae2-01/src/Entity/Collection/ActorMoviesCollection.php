<?php

declare(strict_types=1);

namespace Entity\Collection;

use Entity\ActorMovies;
use Database\MyPdo;
use PDO;

class ActorMoviesCollection
{
    /**
     * permet de renvoyer un tableau des acteurs ayant joués dans un film donné
     * @return ActorMovies[]
     */
    public static function findAll(int $movieId): array
    {
        $request = MyPDO::getInstance()->prepare(
            <<<'SQL'
             SELECT  name,birthday,deathday,biography,placeOfBirth,avatarId,p.id
             FROM people p, cast c
             WHERE p.id=c.peopleId
                AND c.movieId= :movieId
SQL
        );
        $request->bindValue(':movieId', $movieId);
        //$request->setFetchMode(PDO::FETCH_CLASS, ActorMovies::class);
        $request->execute();
        return $request->fetchAll(PDO::FETCH_CLASS, ActorMovies::class);

    }
}
