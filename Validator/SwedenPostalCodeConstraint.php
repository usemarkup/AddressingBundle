<?php

namespace Markup\AddressingBundle\Validator;

use Symfony\Component\Validator\Constraints\Regex as RegexConstraint;

/**
* @Annotation
*/
class SwedenPostalCodeConstraint extends RegexConstraint
{
    public $message = 'This is not a valid Swedish postal code.';
    public $pattern = '/^(SE?-)?\d{3}\s?\d{2}$/';

    public function getRequiredOptions()
    {
        //override requirement of a pattern option
        return [];
    }

    public function validatedBy()
    {
        return 'regex_postal_code';
    }
}
