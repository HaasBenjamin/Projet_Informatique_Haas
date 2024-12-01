<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Gender
{
    private String $name;
    private int $id;

    /**
     * Accesseur sur l'attribut name de la classe gender
     * @return String
     */
    public function getName(): String
    {
        return $this->name;
    }
    /**
     * Accesseur sur l'attribut id de la classe gender
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
    /**
     * Méthode qui permet de récupérer un genre en particulier grâce à son id
     * @param int $id
     * @return Gender
     */
    public static function findById(int $id): Gender
    {
        $req = MyPDO::getInstance()->prepare(
            <<<'SQL'
            SELECT  *
            FROM genre
            WHERE id = :idgender
SQL
        );
        $req->bindValue(':idgender', $id);
        $req->setFetchMode(PDO::FETCH_CLASS, Gender::class);
        $req->execute();
        if (!($line = $req->fetch())) {
            throw new EntityNotFoundException("id du cover invalide");
        }
        return $line;
    }


}
