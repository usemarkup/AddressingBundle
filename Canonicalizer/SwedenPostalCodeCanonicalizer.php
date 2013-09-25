<?php

namespace Markup\AddressingBundle\Canonicalizer;

/**
* A canonicalizer for Swedish postal codes.
*/
class SwedenPostalCodeCanonicalizer implements CanonicalizerInterface
{
    public function canonicalize($input)
    {
        $numbersOnly = preg_replace('/\D/', '', $input);
        if (strlen($numbersOnly) !== 5) {
            return $input;
        }

        return sprintf('%s %s', substr($numbersOnly, 0, 3), substr($numbersOnly, 3, 2));
    }
}
