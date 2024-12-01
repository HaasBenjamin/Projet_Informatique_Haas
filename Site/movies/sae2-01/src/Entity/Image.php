<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Image
{
    private int $id;
    private string $jpeg;

    /**Accesseur sur l'attribut id de la classe Image
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**Accesseur sur l'attribut jpeg de la classe Movie
     * @return string
     */
    public function getJpeg(): string
    {
        return $this->jpeg;
    }

    /**Méthodes qui renvoie une image selon le id donnée en paramètre
     * @param int $ImageId
     * @return Image
     */
    public static function findByiD(int $ImageId): Image
    {
        $requete=MyPdo::getInstance()->prepare(
            <<<SQL
                SELECT id,jpeg
                FROM image
                WHERE id=:ImageId;

SQL
        );
        $requete->execute([":ImageId"=>$ImageId]);
        $requete->setFetchMode(PDO::FETCH_CLASS, Image::class);
        if(!($ligne = $requete->fetch())) {
            throw new EntityNotFoundException("Id not found");
        }
        return $ligne;
    }

}
