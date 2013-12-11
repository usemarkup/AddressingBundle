<?php

namespace Markup\AddressingBundle\Tests\Canonicalizer;

use Markup\AddressingBundle\Canonicalizer\UnitedKingdomPostcodeCanonicalizer;

/**
* A test for a canonicalizer object that can take a postal code that is recognisable as a United Kingdom postcode and transform it to a canonical form.
*/
class UnitedKingdomPostcodeCanonicalizerTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->canonicalizer = new UnitedKingdomPostcodeCanonicalizer();
    }

    public function testIsCanonicalizer()
    {
        $this->assertTrue($this->canonicalizer instanceof \Markup\AddressingBundle\Canonicalizer\CanonicalizerInterface);
    }

    /**
     * @dataProvider postcodes
     **/
    public function testCanonicalize($input, $output)
    {
        $this->assertEquals($output, $this->canonicalizer->canonicalize($input));
    }

    public function postcodes()
    {
        return array(
            // array('SW1A 1AA', 'SW1A 1AA'),
            // array('SW1A1AA', 'SW1A 1AA'),
            // array('sW1a1Aa', 'SW1A 1AA'),
            // array('sw1a  1aa', 'SW1A 1AA'),
            // array('  SW1A 1AA ', 'SW1A 1AA'),
            // array('CR01EW', 'CR0 1EW'),
            // array('CRO1EW', 'CRO1EW'),
            array('w1f9qs', 'W1F 9QS'),
            );
    }
}
