<?php

namespace Markup\AddressingBundle\Validator;

use Symfony\Component\Validator\Constraint;

class FixedLengthDigitPostalCodeConstraint extends Constraint
{
    public $message = 'The postal code is invalid.';

    public $length;
} 
