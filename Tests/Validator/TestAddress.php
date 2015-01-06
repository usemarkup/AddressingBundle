<?php

namespace Markup\AddressingBundle\Tests\Validator;

/**
 * A simplified address-like class for use with tests.
 */
class TestAddress
{
    /**
     * @var string
     */
    private $region = '';

    /**
     * @var string
     */
    private $postalCode = '';

    /**
     * @var string
     */
    private $country = '';

    /**
     * @return string
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion($region)
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * @param string $postalCode
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country)
    {
        $this->country = $country;
    }
}
