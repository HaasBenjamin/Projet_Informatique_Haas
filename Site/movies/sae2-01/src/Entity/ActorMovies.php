<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class ActorMovies
{
    private String $name;

    private ?String $birthday;

    private ?String $deathday;

    private String $biography;

    private ?String $placeOfBirth;

    private ?int $avatarId;

    private int $id;

    /**
     * Accesseur sur l'attribut name de la classe ActorMovies
     * @return String
     */
    public function getName(): String
    {
        return $this->name;
    }
    /**
     * Accesseur sur l'attribut birthday de la classe ActorMovies
     * @return String
     */
    public function getBirthday(): ?String
    {
        return $this->birthday;
    }
    /**
     * Accesseur sur l'attribut deathday de la classe ActorMovies
     * @return String
     */
    public function getDeathday(): ?String
    {
        return $this->deathday;
    }
    /**
     * Accesseur sur l'attribut biography de la classe ActorMovies
     * @return String
     */
    public function getBiography(): String
    {
        return $this->biography;
    }
    /**
     * Accesseur sur l'attribut placeOfBirth de la classe ActorMovies
     * @return String
     */
    public function getPlaceOfBirth(): ?String
    {
        return $this->placeOfBirth;
    }
    /**
     * Accesseur sur l'attribut avatarId de la classe ActorMovies
     * @return int
     */
    public function getAvatarId(): ?int
    {
        return $this->avatarId;
    }
    /**
     * Accesseur sur l'attribut id de la classe ActorMovies
    * @return int
    */
    public function getId(): int
    {
        return $this->id;
    }

    /**Méthode qui renvoie un actormovie selon son identifant
     * Renvoie un film précis à l'aide de son id ou EntityNotFoundException
     * @param int $id
     * @return ActorMovies
     */
    public static function findById(int $id): ActorMovies
    {
        $request = MyPDO::getInstance()->prepare(
            <<<'SQL'
    SELECT  *
    FROM people
    WHERE id = :idactor
SQL
        );
        $request->bindValue(':idactor', $id);
        $request->setFetchMode(PDO::FETCH_CLASS, ActorMovies::class);
        $request->execute();
        if (!($ligne = $request->fetch())) {
            throw new EntityNotFoundException("id de l'acteur invalide");
        }
        return $ligne;
    }

    /**Méthodes qui le role d'un acteur dans un film dont l'id est donnée en argument
     * @param int $movieId
     * @return String
     */

    public function getRole(int $movieId): String
    {
        $request = MyPDO::getInstance()->prepare(
            <<<'SQL'
    SELECT  role
    FROM cast
    WHERE movieId= :movieId
        AND peopleId= :peopleId
SQL
        );
        $request->bindValue(':movieId', $movieId);
        $request->bindValue(':peopleId', $this->id);
        $request->setFetchMode(PDO::FETCH_ASSOC);
        $request->execute();
        if (!($ligne = $request->fetch())) {
            throw new EntityNotFoundException("id de l'acteur invalide");
        }
        return $ligne['role'];
    }
}
