<?php

namespace Markup\AddressingBundle\Checker;

use Markup\Addressing\AddressInterface;

class AddressUnderCheck implements AddressInterface
{
    /**
     * @var string
     */
    private $postalCode;

    /**
     * @var string
     */
    private $country;

    /**
     * @param string $postalCode
     * @param string $country
     */
    public function __construct($postalCode, $country)
    {
        $this->postalCode = $postalCode;
        $this->country = $country;
    }

    /**
     * Gets a name for the recipient at this address. Returns null if one is not specified.
     *
     * @return string|null
     **/
    public function getRecipient()
    {
        return null;
    }

    /**
     * Gets whether the address has a recipient defined.
     *
     * @return bool
     **/
    public function hasRecipient()
    {
        return false;// TODO: Implement hasRecipient() method.
    }

    /**
     * Gets the numbered address line, counting from one.  If there is no address line for provided number, return null.
     *
     * @param  int $lineNumber
     * @return string|null
     **/
    public function getStreetAddressLine($lineNumber)
    {
        return null;
    }

    /**
     * Gets the address lines that are part of the street address - i.e. everything up until the postal town.
     *
     * @return array
     **/
    public function getStreetAddressLines()
    {
        return [];
    }

    /**
     * Gets the locality for this address. This field is often referred to as a "town" or a "city".
     *
     * @return string
     **/
    public function getLocality()
    {
        return '';
    }

    /**
     * Gets the region for this address.  This field is often referred to as a "county", "state" or "province".
     * If no region is indicated as part of the address information, returns an empty string.
     *
     * @return string
     **/
    public function getRegion()
    {
        return '';
    }

    /**
     * Gets the postal code for this address.
     * If no postal code is indicated as part of the address information, returns an empty string.
     *
     * @return string
     **/
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Gets the ISO-3166-2 (alpha-2) representation of the country indicated for this address.
     * i.e. 'GB' for United Kingdom (*not* 'UK'), 'US' for United States.
     *
     * @return string
     **/
    public function getCountry()
    {
        return $this->country;
    }
}
