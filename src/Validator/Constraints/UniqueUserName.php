<?php

namespace ExpressLibrary\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

class UniqueUserName extends Constraint
{
    public $message = "This User Name already taken";
}