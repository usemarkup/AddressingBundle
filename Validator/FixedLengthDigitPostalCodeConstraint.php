<?php

namespace Markup\AddressingBundle\Validator;

use Symfony\Component\Validator\Constraint;

class FixedLengthDigitPostalCodeConstraint extends Constraint
{
    public $message = 'The postal code is invalid.';

    public $length;

    public function validatedBy()
    {
        return 'fixed_length_digit_postal_code';
    }
}
