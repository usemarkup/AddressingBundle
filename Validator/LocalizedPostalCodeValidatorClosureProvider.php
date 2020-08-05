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
     * @var CountryRegexOverrideProvider
     */
    private $countryRegexOverrideProvider;

    public function __construct(ConstraintValidatorFactoryInterface $validatorFactory, CountryRegexOverrideProvider $countryRegexOverrideProvider)
    {
        $this->validatorFactory = $validatorFactory;
        $this->countryRegexOverrideProvider = $countryRegexOverrideProvider;
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
        //first, check if there is a regex override for the country
        $override = $this->countryRegexOverrideProvider->getOverrideFor($country);
        if ($override) {
            if (!is_array($override)) {
                $override = [$override];
            }

            return $this->createValidatorClosureForConstraint($this->getMultipleRegexConstraint($override, $message));
        }

        //otherwise just match against country
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

            case 'SE':
                $constraint = new SwedenPostalCodeConstraint();
                if ($message) {
                    $constraint->message = $message;
                }

                return $this->createValidatorClosureForConstraint($constraint);

            case 'BE':
            case 'NO':
                return $this->createValidatorClosureForConstraint($this->getFixedLengthDigitConstraint(4, $message));

            case 'ES':
            case 'FI':
            case 'IT':
            case 'FR':
            case 'DE':
                return $this->createValidatorClosureForConstraint($this->getFixedLengthDigitConstraint(5, $message));

            case 'DK':
                return $this->createValidatorClosureForConstraint($this->getMultipleRegexConstraint(['/^[1-9]\d{3}$/'], $message));

            case 'NL':
                return $this->createValidatorClosureForConstraint($this->getMultipleRegexConstraint(['/^\d{4}\s[A-Z]{2}$/'], $message));

            case 'PL':
                return $this->createValidatorClosureForConstraint($this->getMultipleRegexConstraint(['/^\d{2}\-\d{3}$/'], $message));

            case 'PT':
                return $this->createValidatorClosureForConstraint($this->getMultipleRegexConstraint(['/^\d{4}\-\d{3}$/'], $message));

            case 'CA':
                return $this->createValidatorClosureForConstraint($this->getMultipleRegexConstraint(['/^[A-Z][0-9][A-Z] [0-9][A-Z][0-9]$/'], $message));

            case 'US':
                return $this->createValidatorClosureForConstraint($this->getMultipleRegexConstraint(['/^[0-9]{5}$/', '/^[0-9]{5}\-[0-9]{4}$/'], $message));

            case 'IE':
                $constraint = new IrelandPostcodeConstraint();
                if ($message) {
                    $constraint->message = $message;
                }

                return $this->createValidatorClosureForConstraint($constraint);
            default:
                return null;
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
     * @param string $message
     * @return FixedLengthDigitPostalCodeConstraint
     */
    private function getFixedLengthDigitConstraint($length, $message = null)
    {
        $constraint = new FixedLengthDigitPostalCodeConstraint();
        if (null !== $message) {
            $constraint->message = $message;
        }
        $constraint->length = intval($length);

        return $constraint;
    }

    /**
     * @param array $regexes
     * @param string $message
     * @return MultipleRegexConstraint
     */
    private function getMultipleRegexConstraint(array $regexes, $message = null)
    {
        $constraint = new MultipleRegexConstraint();
        if (null !== $message) {
            $constraint->message = $message;
        }
        $constraint->patterns = $regexes;

        return $constraint;
    }
}
