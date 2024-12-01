<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;
use Html\AppWebPage;

try {
    $appWebPage = new AppWebPage();
    $appWebPage->appendCssUrl("css/Actors-details.css");
    $appWebPage->appendContent(<<<HTML
 <div class="accueil"><a class="bouton" href="/">Home</a></div>
HTML);
    if (!(isset($_GET['actorId'])) || !ctype_digit($_GET['actorId'])) {
        throw new ParameterException("Paramètre incorrect");
    }
    $act=\Entity\ActorMovies::findById((int)$_GET['actorId']);
    $appWebPage->setTitle("Films - {$appWebPage->escapeString($act->getName())}");
    $death=$act->getDeathday();
    if($death==null) {
        $death="Alive";
    }
    $appWebPage->appendContent(<<<HTML
    <div class='content'>
        <div class='presentation'>
            <div class="avatar">
            <img class="avatarid" src="image.php?imageId={$act->getAvatarId()}&gender=actor" alt=''>
            </div>
            <div class='Infrormation'>
                <div class="Important">
                    <div class="Title">{$appWebPage->escapeString($act->getName())}</div>
                    <div class="place">{$appWebPage->escapeString($act->getPlaceOfBirth())}</div>
                    <div class="date">
                        <p>{$appWebPage->escapeString($act->getBirthday())}</p>
                        <p>&nbsp;-&nbsp;</p>
                        <p>{$appWebPage->escapeString($death)}</p>
                    </div>
                    <div class="bio">{$appWebPage->escapeString($act->getBiography())}</div>
                </div>
            </div> 
        </div>       
        
HTML);
    $tab=\Entity\Collection\MovieCollection::getMovieByactorId($act->getId());
    $appWebPage->appendContent("<div class='movies'>");
    foreach($tab as $elt) {
        $appWebPage->appendContent(<<<HTML
            
            <a class="movie" href="Movies-details.php?movieId={$elt->getId()}">
            <div class="poster">
                <img class="photo" src="image.php?imageId={$elt->getPosterId()}">
             </div> 
             <div class="info">
                <div class="inf_movie">
                    
                    <div class="tiltle_movie">{$appWebPage->escapeString($elt->getTitle())}</div>
                    <div>{$appWebPage->escapeString($elt->getReleaseDate())}</div>
                    
                </div>
                <div class="role">{$appWebPage->escapeString($act->getRole($elt->getId()))}</div>
            </div>
            
            </a>  
       
HTML);
    }
    $appWebPage->appendContent("</div>");
    $appWebPage->appendContent("</div>");
    $appWebPage->appendContent("<footer class='footer'>Dernière modification:{$appWebPage->getLastModification()}</footer>");
    echo $appWebPage->toHTML();
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception $e) {
    echo $e->getMessage();

    http_response_code(500);
}
