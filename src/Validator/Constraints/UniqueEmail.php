<?php

namespace ExpressLibrary\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class UniqueEmail extends Constraint
{
    public $message = "This email already used";
}