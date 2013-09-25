<?php

namespace Markup\AddressingBundle\Tests\Validator;

use Markup\AddressingBundle\Validator\PostalCodeValidator;

/**
* A test for a postal code validator that can perform localized postal code validation where available.
*/
class PostalCodeValidatorTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->validatorProvider = $this->getMockBuilder('Markup\AddressingBundle\Validator\LocalizedPostalCodeValidatorClosureProvider')
            ->disableOriginalConstructor()
            ->getMock();
        $this->validator = new PostalCodeValidator($this->validatorProvider);
    }

    public function testIsValidator()
    {
        $this->assertInstanceOf('Symfony\Component\Validator\ConstraintValidatorInterface', $this->validator);
    }

    public function testPassingNonObjectThrowsInvalidArgumentException()
    {
        $constraint = $this->getMockBuilder('Symfony\Component\Validator\Constraint')
            ->disableOriginalConstructor()
            ->getMock();
        $value = 'POSTCODE';
        $this->setExpectedException('InvalidArgumentException');
        $this->validator->validate($value, $constraint);
    }
}
