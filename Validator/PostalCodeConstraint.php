<?php

namespace Markup\AddressingBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
* A class-based validator for postal codes that applies validation on a per-country basis.
*/
class PostalCodeConstraint extends Constraint
{
    public $message = 'The postal code is invalid.';

    public function validatedBy()
    {
        return 'postal_code';
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
