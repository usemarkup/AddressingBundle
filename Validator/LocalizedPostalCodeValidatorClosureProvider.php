<?php

namespace Markup\AddressingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidatorFactoryInterface;

/**
* A provider for validators that can validate postcodes for a given country.
*/
class LocalizedPostalCodeValidatorClosureProvider
{
    /**
     * @var ConstraintValidatorFactoryInterface
     **/
    private $validatorFactory;

    /**
     * @param ConstraintValidatorFactoryInterface $validatorFactory
     **/
    public function __construct(ConstraintValidatorFactoryInterface $validatorFactory)
    {
        $this->validatorFactory = $validatorFactory;
    }

    /**
     * Fetches a postal code validator for a provided country within a closure that will perform the validation when a postal code value and a validator execution context are passed in.  Returns null if no appropriate validator can be found for the country.
     *
     * @param string $country An ISO3166 alpha-2 representation of a country.
     * @param string $message A message to use for the constraint. (Optional.)
     *
     * @return \Closure|null
     **/
    public function fetchValidatorForCountry($country, $message = null)
    {
        switch ($country) {
            case 'GB':
            case 'IM':
            case 'GG':
            case 'JE':
                $constraint = new UkPostcodeConstraint();
                if ($message) {
                    $constraint->message = $message;
                }

                return $this->createValidatorClosureForConstraint($constraint);
                break;

            case 'SE':
                $constraint = new SwedenPostalCodeConstraint();
                if ($message) {
                    $constraint->message = $message;
                }

                return $this->createValidatorClosureForConstraint($constraint);
                break;

            case 'DK':
                return $this->createValidatorClosureForConstraint($this->getFixedLengthDigitConstraint(4));
                break;

            case 'ES':
            case 'FI':
            case 'IT':
                return $this->createValidatorClosureForConstraint($this->getFixedLengthDigitConstraint(5));
                break;

            default:
                return null;
                break;
        }
    }

    /**
     * Creates a closure that provides a validator that pertains to a provided constraint.
     *
     * @param  Constraint $constraint
     * @return \Closure
     **/
    private function createValidatorClosureForConstraint(Constraint $constraint)
    {
        $validatorFactory = $this->validatorFactory;

        return function ($value, $executionContext) use ($constraint, $validatorFactory) {
            $validator = $validatorFactory->getInstance($constraint);
            $validator->initialize($executionContext);
            $validator->validate($value, $constraint);
        };
    }

    /**
     * @param int $length
     * @return FixedLengthDigitPostalCodeConstraint
     */
    private function getFixedLengthDigitConstraint($length)
    {
        $constraint = new FixedLengthDigitPostalCodeConstraint();
        $constraint->length = intval($length);

        return $constraint;
    }
}
