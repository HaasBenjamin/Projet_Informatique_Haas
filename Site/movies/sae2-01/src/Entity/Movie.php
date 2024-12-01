<?php

declare(strict_types=1);

namespace Entity;

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use PDO;

class Movie
{
    private int|null $id;
    private string $title;
    private string $tagline;
    private int $runtime;
    private string $releaseDate;
    private string $overview;
    private string $originalTitle;
    private string $originalLanguage;
    private ?int $posterId;

    /**
     * Accesseur sur l'attribut id de la classe Movie
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Accesseur sur l'attribut title de la classe Movie
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Accesseur sur l'attribut tagline de la classe Movie
     * @return string
     */
    public function getTagline(): string
    {
        return $this->tagline;
    }

    /**
     * Accesseur sur l'attribut runtime de la classe Movie
     * @return string
     */
    public function getRuntime(): int
    {
        return $this->runtime;
    }

    /**
     * Accesseur sur l'attribut releasedate de la classe Movie
     * @return string
     */
    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    /**
     * Accesseur sur l'attribut overview de la classe Movie
     * @return string
     */
    public function getOverview(): string
    {
        return $this->overview;
    }


    /**
     * Accesseur sur l'attribut originaltitle de la classe Movie
     * @return string
     */
    public function getOriginalTitle(): string
    {
        return $this->originalTitle;
    }

    /**
     * Accesseur sur l'attribut originallanguage de la classe Movie
     * @return string
     */
    public function getOriginalLanguage(): string
    {
        return $this->originalLanguage;
    }

    /**
     * Accesseur sur l'attribut posterid de la classe Movie
     * @return ?int
     */
    public function getPosterId(): ?int
    {
        return $this->posterId;
    }
    /**
     * Modificateur de l'attribut id de la classe Movie
     * @param int|null $id
     * @return Movie
     */
    public function setId(?int $id): Movie
    {
        $this->id = $id;
        return $this;
    }
    /**
     * Modificateur de l'attribut title de la classe Movie
     * @param string $title
     * @return Movie
     */
    public function setTitle(string $title): Movie
    {
        $this->title = $title;
        return $this;
    }
    /**
     * Modificateur de l'attribut tagline de la classe Movie
     * @param string $tagline
     * @return Movie
     */
    public function setTagline(string $tagline): Movie
    {
        $this->tagline = $tagline;
        return $this;
    }
    /**
     * Modificateur de l'attribut runtime de la classe Movie
     * @param string $runtime
     * @return Movie
     */
    public function setRuntime(int $runtime): Movie
    {
        $this->runtime = $runtime;
        return $this;
    }
    /**
     * Modificateur de l'attribut releasedate de la classe Movie
     * @param string $releaseDate
     * @return Movie
     */
    public function setReleaseDate(string $releaseDate): Movie
    {
        $this->releaseDate = $releaseDate;
        return $this;
    }
    /**
     * Modificateur de l'attribut overview de la classe Movie
     * @param string $overview
     * @return Movie
     */
    public function setOverview(string $overview): Movie
    {
        $this->overview = $overview;
        return $this;
    }

    /**
     * Modificateur de l'attribut originalTitle de la classe Movie
     * @param string $originalTitle
     * @return Movie
     */
    public function setOriginalTitle(string $originalTitle): Movie
    {
        $this->originalTitle = $originalTitle;
        return $this;
    }
    /**
     * Modificateur de l'attribut originallanguage de la classe Movie
     * @param string $originalLanguage
     * @return Movie
     */
    public function setOriginalLanguage(string $originalLanguage): Movie
    {
        $this->originalLanguage = $originalLanguage;
        return $this;
    }
    /**
     * Modificateur de l'attribut posterid de la classe Movie
     * @param ?int $posterId
     * @return Movie
     */
    public function setPosterId(?int $posterId): Movie
    {
        $this->posterId = $posterId;
        return $this;
    }



    /**Méthode qui renvoie un movie selon son identifant
     * Renvoie un film précis à l'aide de son id ou EntityNotFoundException
     * @param int $id
     * @return Movie
     */
    public static function findById(int $id): Movie //throws EntityNotFoundException
    {
        $request = MyPDO::getInstance()->prepare(
            <<<'SQL'
    SELECT  *
    FROM movie
    WHERE id = :idMovie
SQL
        );
        $request->bindValue(':idMovie', $id);
        $request->setFetchMode(PDO::FETCH_CLASS, Movie::class);
        $request->execute();
        if (!($ligne = $request->fetch())) {
            throw new EntityNotFoundException("id du film invalide");
        }
        return $ligne;
    }

    /** Méthode qui permet de supprimer un movie de la base donnée
     * @return $this
     */
    public function delete(): Movie
    {
        $request = MyPDO::getInstance()->prepare(
            <<<'SQL'
            DELETE FROM movie_genre
            WHERE movieId=:idMovie;

            DELETE FROM cast
            WHERE movieId= :idMovie;

            DELETE FROM movie
            WHERE id=:idMovie;
SQL
        );
        $request->bindValue(':idMovie', $this->getId());
        $request->execute();
        $this->setId(null);
        return $this;
    }

    /**
     * Constructeur de la classe movie
     */
    private function __construct()
    {

    }


    /** Méthode qui crée un movie avec ses differents attributs donnés en paramètre elle fait appelle au constructeur de la classe
     * @param String $title
     * @param String $tagline
     * @param String $runtime
     * @param String $releaseDate
     * @param String $overview
     * @param String $originaltitle
     * @param String $originalLanguage
     * @param int|null $posterId
     * @param int|null $id
     * @return Movie
     */
    public static function create(String $title, String $tagline, int $runtime, String $releaseDate, String $overview, String $originaltitle, String $originalLanguage, ?int $posterId, ?int $id=null): Movie

    {
        $mov=new Movie();
        $mov->setId($id);
        $mov->setTitle($title);
        $mov->setTagline($tagline);
        $mov->setRuntime($runtime);
        $mov->setReleaseDate($releaseDate);
        $mov->setOverview($overview);
        $mov->setOriginalTitle($originaltitle);
        $mov->setOriginalLanguage($originalLanguage);
        $mov->setPosterId($posterId);
        return $mov;
    }

    /**Methode qui permet modifier un movie dans la base de donnée
     * @return $this
     */
    protected function update(): Movie
    {
        $request=MyPdo::getInstance()->prepare(
            <<<SQL
            UPDATE movie
            SET title=:Title,
                tagline=:Tagline,
                runtime=:Runtime,
                releasedate=:Release,
                overview=:Overview,
                originaltitle=:Original,
                originalLanguage=:Language
            WHERE id=:MovieId ;


SQL
        );
        $request->execute([":Title"=>$this->getTitle(),":Tagline"=>$this->getTagline(),":Runtime"=>$this->getRuntime(),
            "Release"=>$this->getReleaseDate(),":Overview"=>$this->getOverview(),":Original"=>$this->getoriginalTitle(),":Language"=>$this->getOriginalLanguage(),
            ":MovieId"=>$this->getId()]);
        return $this;
    }

    /**Méthodes qui permet d'ajouter un movie dans la base de donnée
     * @return $this
     */
    protected function insert(): Movie
    {
        if ($this->posterId==null) {
            $request = MyPDO::getInstance()->prepare(
                <<<'SQL'
            INSERT INTO movie(originalLanguage,originalTitle,overview,releaseDate,runtime,tagline,title)
            VALUES( :originalLanguage,:originalTitle,:overview,:releaseDate,:runtime,:tagline,:title)
SQL
            );
        } else {
            $request = MyPDO::getInstance()->prepare(
                <<<'SQL'
            INSERT INTO movie(originalLanguage,originalTitle,overview,releaseDate,runtime,tagline,title,posterId)
            VALUES( :originalLanguage,:originalTitle,:overview,:releaseDate,:runtime,:tagline,:title,:posterId)
SQL
            );
            $request->bindValue(':posterId', $this->getPosterId());
        }


        $request->bindValue(':originalLanguage', $this->getOriginalLanguage());
        $request->bindValue(':originalTitle', $this->getOriginalTitle());
        $request->bindValue(':overview', $this->getOverview());
        $request->bindValue(':releaseDate', $this->getReleaseDate());
        $request->bindValue(':runtime', $this->getRuntime());
        $request->bindValue(':tagline', $this->getTagline());
        $request->bindValue(':title', $this->getTitle());
        $request->execute();
        $this->setId((int)MYPDO::getInstance()->lastInsertId());

        return $this;
    }


    /** Méthode qui permet d'enregistrer les modifications ou insertion d'un movie dans la base de donnée
     * @return $this
     */
    public function save(): Movie
    {
        if ($this->getId() == null) {
            $this->insert();
        } else {
            $this->update();
        }
        return $this;
    }

}
