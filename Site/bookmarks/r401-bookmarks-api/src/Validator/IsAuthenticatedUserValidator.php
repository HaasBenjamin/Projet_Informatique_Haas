<?php

namespace App\Validator;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsAuthenticatedUserValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var IsAuthenticatedUser $constraint */
        if ($value === $this->security->getUser()) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value?->getFirstName() ?? 'none')
            ->addViolation();
    }

    public function __construct(private readonly Security $security)
    {
    }
}
