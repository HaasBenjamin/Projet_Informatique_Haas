<?php

declare(strict_types=1);

namespace Html\Form;

use Entity\Movie;
use Exception\ParameterException;
use Html\StringEscaper;

class MoviesForm
{
    use StringEscaper;
    private ?Movie $movie;

    /**
     * @param ?Movie $movie
     */
    public function __construct(?Movie $movie=null)
    {
        $this->movie = $movie;
    }

    /**
     * Accesseur sur l'attribut movie de la classe moviesForm
     * @return Movie|null
     */
    public function getMovie(): ?Movie
    {
        return $this->movie;
    }

      /**
      * Permet de renvoyer le formulaire html permettant de créer un film
      * @param String $action
      * @return String
      */
    public function getHtmlForm(String $action): String
    {

        return (
            <<<HTML
        <form name="formulaire html" method="post" action=$action>
        <label for="title">
        
        Title
        
        <input name="title" type="text"  value="{$this->escapeString($this->getMovie()?->getTitle())}" required >
        
        </label>
        
        <label for="id">
        <input name="id" type="hidden" value="{$this->getMovie()?->getId()}" >
        </label>
        
        <label for="originalLanguage">
        
        OriginalLanguage
        <input name="originalLanguage" type="text" value="{$this->getMovie()?->getOriginalLanguage()}" required>
        </label>
        
        <label for="originalTitle">
        
        OriginalTitle
        <input name="originalTitle" type="text" value="{$this->getMovie()?->getOriginalTitle()}" required>
        </label>
        
        <label for="overview">
        Overview
        <input name="overview" type="text" value="{$this->getMovie()?->getOverview()}" required>
        </label>
        
        <label for="releaseDate">
        ReleaseDate
        <input name="releaseDate" type="text" value="{$this->getMovie()?->getReleaseDate()}" required>
        </label>
        
        <label for="runtime">
        Runtime
        <td><input name="runtime" type="number" value="{$this->getMovie()?->getRuntime()}" required>
        </label>
        
        <label for="tagline">
        Tagline
        <input name="tagline" type="text" value="{$this->getMovie()?->getTagline()}" required >
        </label>
        
        <label for="posterId">
        <input name="posterId" type="hidden" value="{$this->getMovie()?->getPosterId()}" >
        </label>
        
        
        
        <button type="submit">Envoyer</button>  
        </table>
        </form>
        
        HTML
        );
    }

    /**
     * Méthode permettant de créer une entité à partir des éléments contenus dans le query string
     * @throws ParameterException
     */
    public function setEntityFromQueryString(): void //throws ParameterException
    {
        if (isset($_POST['id']) && ctype_digit($_POST['id' ])) {
            $id=(int)$_POST['id'];
        } else {
            $id=null;
        }

        if (isset($_POST['posterId']) && ctype_digit($_POST['posterId' ])) {
            $posterId=(int)$_POST['posterId'];
        } else {
            $posterId=null;
        }

        if (isset($_POST['title']) && !($_POST['title'] == null)) {

            $title=$this->stripTagsAndTrim($_POST['title']);

        } else {
            throw new ParameterException('Titre pas defini');
        }
        if (isset($_POST['originalLanguage']) && !($_POST['originalLanguage'] == null)) {

            $originalLanguage=$this->stripTagsAndTrim($_POST['originalLanguage']);

        } else {
            throw new ParameterException('OriginalLanguage pas defini');
        }

        if (isset($_POST['originalTitle']) && !($_POST['originalTitle'] == null)) {

            $originalTitle=$this->stripTagsAndTrim($_POST['originalTitle']);

        } else {
            throw new ParameterException('OriginalTitle pas defini');
        }

        if (isset($_POST['overview']) && !($_POST['overview'] == null)) {

            $overview=$this->stripTagsAndTrim($_POST['overview']);

        } else {
            throw new ParameterException('Overview pas defini');
        }

        if (isset($_POST['releaseDate']) && !($_POST['releaseDate'] == null)) {

            $releaseDate=$this->stripTagsAndTrim($_POST['releaseDate']);

        } else {
            throw new ParameterException('ReleaseDate pas defini');
        }

        if (isset($_POST['runtime']) && ctype_digit($_POST['runtime'])) {

            $runtime=(int)$_POST['runtime'];

        } else {
            throw new ParameterException('Runtime pas defini ou mal');
        }

        if (isset($_POST['tagline']) && !($_POST['tagline'] == null)) {

            $tagline=$this->stripTagsAndTrim($_POST['tagline']);

        } else {
            throw new ParameterException('Tagline pas defini');
        }

        $mov=Movie::create($title, $tagline, $runtime, $releaseDate, $overview, $originalTitle, $originalLanguage, $posterId, $id);
        $this->movie=$mov;
    }
}
