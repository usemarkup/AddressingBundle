<?php

namespace Markup\AddressingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\ConstraintValidatorInterface;
use Symfony\Component\Validator\Constraints\NotBlankValidator;
use Symfony\Component\Validator\Constraints\RegexValidator;

/**
* A validator for postal codes based on regexes (that are also mandatory).
*/
class RegexPostalCodeValidator extends ConstraintValidator
{
    /**
     * @var ConstraintValidatorInterface
     **/
    private $regexValidator;

    /**
     * @var ConstraintValidatorInterface
     **/
    private $notBlankValidator;

    /**
     * @param ConstraintValidatorInterface $regexValidator
     * @param ConstraintValidatorInterface $notBlankValidator
     **/
    public function __construct(ConstraintValidatorInterface $regexValidator = null, ConstraintValidatorInterface $notBlankValidator = null)
    {
        if (null !== $regexValidator) {
            $this->regexValidator = $regexValidator;
        } else {
            $this->regexValidator = new RegexValidator();
        }
        if (null !== $notBlankValidator) {
            $this->notBlankValidator = $notBlankValidator;
        } else {
            $this->notBlankValidator = new NotBlankValidator();
        }
    }

    /**
     * {@inheritdoc}
     **/
    public function validate($value, Constraint $constraint)
    {
        $this->regexValidator->initialize($this->context);
        $this->regexValidator->validate($value, $constraint);
        $notBlankConstraint = new NotBlank();
        $notBlankConstraint->message = $constraint->message;
        $this->notBlankValidator->initialize($this->context);
        $this->notBlankValidator->validate($value, $notBlankConstraint);
    }
}
