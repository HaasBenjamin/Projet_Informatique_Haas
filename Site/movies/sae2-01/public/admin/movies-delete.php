<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;

try {
    if (isset($_GET['movieId']) && ctype_digit($_GET['movieId'])) {
        $art=\Entity\Movie::findById((int)$_GET['movieId']);
        $art->delete();
        header('Location: /', response_code:302);
    } else {
        throw new ParameterException('Mauvais id');
    }
} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception $e) {
    echo $e->getMessage();
    http_response_code(500);
}
