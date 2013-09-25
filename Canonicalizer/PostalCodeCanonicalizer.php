<?php

namespace Markup\AddressingBundle\Canonicalizer;

/**
* A canonicalizer object for provided postal codes that can recognise acceptable forms of postal codes for given countries and return a canonical version.
*/
class PostalCodeCanonicalizer
{
    /**
     * Canonicalizes a provided postal code for a given country if it is possible to do so, otherwise returns the postal code unmodified.
     *
     * @param string $postalCode A postal code string.
     * @param string $country    The ISO3166 alpha-2 representation of a country.
     *
     * @return string
     **/
    public function canonicalizeForCountry($postalCode, $country)
    {
        switch ($country) {
            case 'GB':
            case 'IM':
            case 'JE':
            case 'GG':
            case 'GI':
                $ukCanonicalizer = new UnitedKingdomPostcodeCanonicalizer();

                return $ukCanonicalizer->canonicalize($postalCode);
                break;

            case 'SE':
                $seCanonicalizer = new SwedenPostalCodeCanonicalizer();

                return $seCanonicalizer->canonicalize($postalCode);
                break;

            default:
                return $postalCode;
                break;
        }
    }
}
