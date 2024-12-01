<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;

try {

    if (!(isset($_GET['movieId']))) {
        $mov=null;
    } else {
        if (!(ctype_digit($_GET['movieId']))) {
            throw new ParameterException('Movie id invalide');
        } else {
            $mov=\Entity\Movie::findById((int)$_GET['movieId']);
        }
    }
    $webpage=new \Html\AppWebPage('Formulaire ajout artiste');
    $webpage->appendContent('<a href="/" class="accueil">Home</a>');
    $formu=new \Html\Form\MoviesForm($mov);
    $webpage->appendContent($formu->getHtmlForm("movies-save.php"));
    $webpage->appendCssUrl("/css/form.css");
    echo $webpage->toHTML();


} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
