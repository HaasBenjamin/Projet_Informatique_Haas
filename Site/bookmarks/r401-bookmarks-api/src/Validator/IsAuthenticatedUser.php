<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute]
class IsAuthenticatedUser extends Constraint
{

    public $message = 'The user "{{ value }}" is not concerned user.';
}
