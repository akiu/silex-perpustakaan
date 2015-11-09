<?php

namespace ExpressLibrary\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use ExpressLibrary\Validator\Constraints\UniqueEmailValidator;

class UniqueUserNameValidator extends UniqueEmailValidator
{
    public function validate($value, Constraint $constraint)
    {
        $conn = $this->db;

        $userName = $conn->fetchAssoc("SELECT username FROM user WHERE username = ?", [$value]);

        if ($userName['username'])
        {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}