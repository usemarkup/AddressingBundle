<?php

namespace Markup\AddressingBundle\Tests\Canonicalizer;

use Markup\AddressingBundle\Canonicalizer\SwedenPostalCodeCanonicalizer;

/**
* A test for a canonicalizer for Swedish postal codes.
*/
class SwedenPostalCodeCanonicalizerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->canonicalizer = new SwedenPostalCodeCanonicalizer();
    }

    public function testIsCanonicalizer()
    {
        $this->assertTrue($this->canonicalizer instanceof \Markup\AddressingBundle\Canonicalizer\CanonicalizerInterface);
    }

    /**
     * @dataProvider postalCodes
     **/
    public function testCanonicalize($input, $output)
    {
        $this->assertEquals($output, $this->canonicalizer->canonicalize($input));
    }

    public function postalCodes()
    {
        return array(
            array('SE-12345', '123 45'),
            array('S-12345', '123 45'),
            array('12345', '123 45'),
            array('123 456', '123 456'),
            array('12 345', '123 45'),
        );
    }
}
