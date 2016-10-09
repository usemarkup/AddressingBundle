<?php

namespace Markup\AddressingBundle\Checker;

use Markup\Addressing\Canonicalizer\PostalCodeCanonicalizer;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * A checker service that can take a postal code and a country, and check whether the postal code is recognisable as one.
 */
class PostalCodeChecker
{
    /**
     * @var ValidatorInterface
     */
    private $validator;

    /**
     * @param ValidatorInterface $validator
     */
    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param string $postalCode
     * @param string $country
     * @return bool
     */
    public function check($postalCode, $country)
    {
        $violationList = $this->validator->validate(
            new AddressUnderCheck(
                $this->canonicalize($postalCode, $country),
                $country
            )
        );

        return count($violationList) === 0;
    }

    private function canonicalize($postalCode, $country)
    {
        return (new PostalCodeCanonicalizer())->canonicalizeForCountry($postalCode, $country);
    }
}
