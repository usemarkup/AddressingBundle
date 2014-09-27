<?php

namespace Markup\AddressingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
 * A constraint validator that checks a value against multiple regexes. It does *not* allow blank values through.
 */
class MultipleRegexValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid.
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     *
     * @api
     */
    public function validate($value, Constraint $constraint)
    {
        if (!isset($constraint->patterns) || !is_array($constraint->patterns) || empty($constraint->patterns)) {
            return;
        }
        foreach ($constraint->patterns as $pattern) {
            if (preg_match($pattern, $value)) {
                return;
            }
        }
        $this->context->addViolation($constraint->message);
    }
}
