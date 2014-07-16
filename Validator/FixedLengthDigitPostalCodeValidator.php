<?php

namespace Markup\AddressingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class FixedLengthDigitPostalCodeValidator extends ConstraintValidator
{
    /**
     * Checks if the passed value is valid, comprising exactly the correct number of digits as per the length set in the constraint.
     *
     * @param mixed      $value      The value that should be validated
     * @param Constraint $constraint The constraint for the validation
     */
    public function validate($value, Constraint $constraint)
    {
        if (empty($constraint->length)) {
            throw new \LogicException('You must set a length on a fixed length digit postal code constraint.');
        }
        if (!preg_match('/^\d{' . preg_quote(strval($constraint->length)) . '}$/', $value)) {
            $this->context->addViolation($constraint->message);
        }
    }
}
