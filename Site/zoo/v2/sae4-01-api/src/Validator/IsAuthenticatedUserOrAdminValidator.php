<?php

namespace App\Validator;

use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsAuthenticatedUserOrAdminValidator extends ConstraintValidator
{
    public function __construct(private readonly Security $security)
    {
    }
    public function validate($value, Constraint $constraint): void
    {

        /** @var IsAuthenticatedUserOrAdmin $constraint */

        if ($value === $this->security->getUser() || $this->security->isGranted('ROLE_ADMIN')) {
            return;
        }

        $this->context->buildViolation($constraint->message)
            ->setParameter('{{ value }}', $value)
            ->addViolation();
    }
}
