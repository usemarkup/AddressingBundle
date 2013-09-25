<?php

namespace Markup\AddressingBundle\Canonicalizer;

/**
* A canonicalizer for United Kingdom postcodes.
*/
class UnitedKingdomPostcodeCanonicalizer implements CanonicalizerInterface
{
    /**
     * {@inheritdoc}
     **/
    public function canonicalize($input)
    {
        $acceptableRegex = '/^([A-PR-UWYZ0-9][A-HK-Y0-9][AEHMNPRTVXY0-9]?[ABEHMNPRVWXY0-9]? {1,2}[0-9][ABD-HJLN-UW-Z]{2}|GIR 0AA)$/';

        //first, return unmodified any input less than 5 characters long, or anything not a string
        if (!is_string($input) or strlen($input) < 5) {
            return $input;
        }

        //second, remove any spaces, uppercase, and break off the last three characters of the string
        $unspaced = mb_strtoupper(preg_replace('/\s/', '', $input), 'UTF-8');
        $spaced = sprintf('%s %s', substr($unspaced, 0, -3), substr($unspaced, -3));

        //now check against the regex, and return unmodified if it doesn't pass
        if (!preg_match($acceptableRegex, $spaced)) {
            return $input;
        }

        //return the modified postcode
        return $spaced;
    }
}
