<?php

declare(strict_types=1);

use Database\MyPdo;
use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;
use Html\AppWebPage;
use Entity\Collection;

try {
    if ((isset($_POST['gender'])) && (ctype_digit($_POST['gender']))) {
        $movies=Collection\GenderMoviesCollection::findAllMoviesByGender((int)$_POST['gender']);
    } else {
        $movies=Collection\MovieCollection::findAll();
    }

} catch (ParameterException) {
    http_response_code(400);
    exit();
} catch (EntityNotFoundException) {
    http_response_code(404);
    exit();
} catch (Exception) {
    http_response_code(500);
    exit();
}


$webpage =new AppWebPage("Films");
$webpage->appendContent(<<<FORM
<div class="buttons">
<form name='formgender' method="post" action="index.php"> 
    <label for="gen">Gender</label>
    <select name="gender" >
    <option value="Aucun">Annuler les filtres</option>
FORM);

$genders=Collection\GenderMoviesCollection::findAll();
foreach ($genders as $line) {
    $webpage->appendContent(<<<OPTION
<option value="{$line->getId()}">{$line->getName()}</option>
OPTION);
}
$webpage->appendContent("</select><button type='submit'>Envoyer</button></form> ");

$webpage->appendContent("<a class='insert' href='admin/movies-form.php'><div class='add'>Add new movie</div></a></div><div class='content'>");

$genders=Collection\GenderMoviesCollection::findAll();


$webpage->appendContent("<a class='insert' href='admin/movies-form.php'><div class='add'>Add new movie</div></a></div><div class='content'>");

foreach ($movies as $elt) {

    $webpage->appendContent(<<<HTML
        
        <div class='movie'>
        <a href='movies-details.php?movieId={$elt->getId()}'>
        <div class='movie_image'>
                <img src='image.php?imageId={$elt->getPosterId()}&gender=movie' alt=''>
                
            
        <p class='title_movie'>{$webpage->escapeString($elt->getTitle())}</p>
        </a>
         
            </div>
HTML);
    $webpage->appendContent("</div>");


}
$webpage->appendContent("</div>");
$webpage->appendCssUrl("css/style1.css");
$webpage->appendContent(<<<HTML
<footer class='footer'>Dernière modification:{$webpage->getLastModification()}</footer>
HTML);
echo $webpage->toHTML();
