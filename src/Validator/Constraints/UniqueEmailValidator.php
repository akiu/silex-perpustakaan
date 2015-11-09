<?php

namespace ExpressLibrary\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use ExpressLibrary\Db\Db;

class UniqueEmailValidator extends ConstraintValidator
{

    protected $db;

    public function __construct()
    {
        $this->db = Db::getInstance();
    }

    public function validate($value, Constraint $constraint)
    {
        $conn = $this->db;

        $email = $conn->fetchAssoc("SELECT email FROM user WHERE email = ?", [$value]);

        if ($email['email'])
        {
            $this->context->buildViolation($constraint->message)->addViolation();
        }
    }
}