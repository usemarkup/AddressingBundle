<?php

namespace Markup\AddressingBundle\Validator;

use Symfony\Component\Validator\Constraints\Regex as RegexConstraint;

/**
 * @Annotation
 */
class IrelandPostcodeConstraint extends RegexConstraint
{
    public $message = 'This is not a valid Irish postcode.';
    public $pattern = '/^([AC-FHKNPRTV-Y]\d{2}|D6W)[0-9AC-FHKNPRTV-Y]{4}/';

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