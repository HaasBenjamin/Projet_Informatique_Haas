<?php

declare(strict_types=1);

use Entity\Exception\EntityNotFoundException;
use Exception\ParameterException;

try {
    if (empty($_GET['imageId'])) {
        if(isset($_GET['gender'])&&$_GET['gender']=='actor') {
            header('Location: /img/actor.png');
        } else {
            header('Location: /img/movie.png');
        }
    } else {
        if (!isset($_GET['imageId'])&&!ctype_digit($_GET['imageId'])) {
            throw new ParameterException("Id incorrect");
        }
        $img=\Entity\Image::findByiD((int)$_GET['imageId']);
        header('Content-Type: image/jpeg');
        echo $img->getJpeg();
    }

} catch (ParameterException) {
    http_response_code(400);
} catch (EntityNotFoundException) {
    http_response_code(404);
} catch (Exception) {
    http_response_code(500);
}
