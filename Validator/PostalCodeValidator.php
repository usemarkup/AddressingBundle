<?php

namespace Markup\AddressingBundle\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

/**
* A postal code validator that can perform localized postal code validation where available.
*/
class PostalCodeValidator extends ConstraintValidator
{
    /**
     * @var LocalizedPostalCodeValidatorClosureProvider
     **/
    private $localizedValidatorProvider;

    /**
     * @param LocalizedPostalCodeValidatorClosureProvider $validatorProvider
     **/
    public function __construct(LocalizedPostalCodeValidatorClosureProvider $validatorProvider)
    {
        $this->localizedValidatorProvider = $validatorProvider;
    }

    /**
     * {@inheritdoc}
     **/
    public function validate($value, Constraint $constraint)
    {
        //check for accessor methods without dictating use of a specific interface
        if (!is_object($value) or !method_exists($value, 'getCountry') or !method_exists($value, 'getPostalCode')) {
            throw new \InvalidArgumentException(sprintf('%s should be used for validating address objects with getCountry() and getPostalCode() methods.', __CLASS__));
        }

        $address = $value;

        $validatorClosure = $this->localizedValidatorProvider->fetchValidatorForCountry($address->getCountry(), isset($constraint->message) ? $constraint->message : null);
        if (!$validatorClosure instanceof \Closure) {
            //there wasn't a validator for this country, so just return
            return;
        }

        $validatorClosure($address->getPostalCode(), $this->context);
    }
}
