<?php

declare(strict_types=1);


use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;

try {
    $movform=new \Html\Form\MoviesForm();
    $movform->setEntityFromQueryString();
    $movform->getMovie()->save();
    header('Location: /', response_code:302);
} catch (ParameterException) {
    http_response_code(400);
} catch (Exception $e) {
    echo $e->getMessage();
    http_response_code(500);
}
