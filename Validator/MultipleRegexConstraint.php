<?php

namespace Markup\AddressingBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * A validation constraint representing a check of postal codes against multiple possible regexes.
 */
class MultipleRegexConstraint extends Constraint
{
    public $message = 'This postal code does not have one of the allowed formats.';
    public $patterns = [];

    public function validatedBy()
    {
        return 'multiple_regex';
    }
}
