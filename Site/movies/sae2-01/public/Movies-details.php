<?php

declare(strict_types=1);


use Entity\Collection\ActorMoviesCollection;
use Entity\Exception\EntityNotFoundException;
use Entity\Image;
use Entity\Movie;
use Exception\ParameterException;
use Html\AppWebPage;

try {
    $appWebPage=new AppWebPage();
    if (!(isset($_GET['movieId' ])) || !ctype_digit($_GET['movieId' ])) {
        throw new ParameterException("Paramètre incorrect");
    }
    $movieId=(int)$_GET['movieId' ];
    $movie=Movie::findById($movieId);
    $appWebPage->setTitle("Films - {$appWebPage->escapeString($movie->getTitle())}");

    $appWebPage->appendContent(<<<HTML
<div class="buttons">
        <a href="/"><div class="accueil">Home</div></a>
        <a href="admin/movies-form.php?movieId={$movieId}"><div class="Update">Update</div></a>
        <a href="admin/movies-delete.php?movieId={$movieId}"><div class="Delete">Delete</div></a>
</div>
<div class="content">
    <div class="presentation">
        <div class="poster">
            <img src="image.php?imageId={$movie->getPosterId()}&gender=movie" alt="">
        </div>
        <div class="information">
                <div class="Important">
                <div class="Title">{$appWebPage->escapeString($movie->getTitle())}</div>
                <div class="date">{$movie->getReleaseDate()}</div>
                </div>
            <div class="Original">{$appWebPage->escapeString($movie->getOriginalTitle())}</div>
            <div class="Slogan">{$appWebPage->escapeString($movie->getTagline())}</div>
            <div class="Resume">{$appWebPage->escapeString($movie->getOverview())}</div>
            
        
    </div>
    </div>
    
HTML);
    $actors=ActorMoviesCollection::findAll($movieId);
    $appWebPage->appendContent("<div class='Actors'>");
    foreach ($actors as $line) {
        $appWebPage->appendContent(<<<HTML
        <div class="Actor">

        <a href="Actor-details.php?actorId={$line->getId() }" class="Image"><img src="image.php?imageId={$line->getAvatarId()}&gender=actor" alt=""></a>
        <div class="Personnal">
         <a href="Actor-details.php?actorId={$line->getId()}" class="role">{$appWebPage->escapeString($line->getRole($movieId))}</a>
        <a href="Actor-details.php?actorId={$line->getId()}" class="Name">{$appWebPage->escapeString($line->getName())}</a>

        
        </div>
        </div>
        
HTML);

    }
    $appWebPage->appendContent("</div></div></div><footer class='footer'>Dernière modification:{$appWebPage->getLastModification()}</footer>");
    $appWebPage->appendCssUrl("/css/Actors-Movies-css.css");
    $appWebPage->appendCss(<<<CSS
html{
background-image: url("image.php?imageId={$movie->getPosterId()}&gender=movie");
background-size: cover;
}

CSS);
    echo $appWebPage->toHTML();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
